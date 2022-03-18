<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Cashier\Billable;

class Company extends Model
{

    use HasFactory, Billable;

    protected $table = 'companies';
    protected $fillable = ['title', 'domain', 'password', 'cashback_percent', 'cashback_percent_level_1',
        'cashback_percent_level_2', 'description', 'personal_rating',
        'image', 'latitude', 'longitude', 'position', 'company_group_id', 'properties', 'callback_url',
        'socials', 'is_active', 'upload_vk_url', 'creator_id', 'tariff_id'];
    protected $casts = [
        'socials' => 'array',
        'properties' => 'array',
    ];
    protected $cardUpFront = false;
    protected $appends = ['story', 'news', 'admins', 'vk_upload'];

    public function users()
    {
        return $this->belongsToMany(User::class)->using(CompanyUser::class);
    }

    public function group()
    {
        return $this->belongsTo(GroupCompany::class, 'company_group_id');
    }

    public function regions()
    {
        return $this->belongsToMany(Region::class)->using(CompanyRegion::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class)->using(CompanyCategory::class);
    }

    public function companyAlerts()
    {
        return $this->HasMany(CompanyAlert::class);
    }

    public function friendsByCompany()
    {
        return $this->HasMany(UsersFriedsByCompany::class);
    }

    public function histories()
    {
        return $this->HasMany(HistoryUsersCompany::class);
    }

    public function products()
    {
        return $this->HasMany(Product::class);
    }

    public function promocodes()
    {
        return $this->HasMany(Promocode::class);
    }

    public function advertising()
    {
        return $this->HasMany(CompanyAdvertising::class);
    }

    public function financesAndTariffs()
    {
        return $this->HasMany(FinanceAndTariff::class);
    }

    public function financeHistory()
    {
        return $this->HasMany(FinanceHistory::class);
    }

    public function tariff()
    {
        return $this->belongsTo(Tariff::class);
    }

    /**
     * Get the customer name that should be synced to Stripe.
     *
     * @return string|null
     */
    public function stripeName()
    {
        return $this->title;
    }

    public function getStoryAttribute()
    {
        if (!is_null($this->tariff_id)) {
            $tariff = Tariff::where('id', $this->tariff_id)->first();
            $stories = CompanyAdvertising::where(['type' => 'Сторис', 'company_id' => $this->id])
                ->where('created_at', '>=', Carbon::now()->subMonth())->count();
            if ($tariff->stories > $stories) {
                return true;
            }
            return false;
        }
        return true;
    }

    public function getNewsAttribute()
    {
        if (!is_null($this->tariff_id)) {
            $tariff = Tariff::where('id', $this->tariff_id)->first();
            $news = CompanyAdvertising::where(['type' => 'Баннер', 'company_id' => $this->id])
                ->where('created_at', '>=', Carbon::now()->subMonth())->get()->count();
            if ($tariff->news > $news) {
                return true;
            }
            return false;
        }
        return true;

    }

    public function getAdminsAttribute()
    {
        if (!is_null($this->tariff_id)) {
            $tariff = Tariff::where('id', $this->tariff_id)->first();
            $admins = CompanyUser::where(['company_id' => $this->id, 'role' => 'admin'])->get()->count();
            if ($tariff->admins > $admins) {
                return true;
            }
            return false;
        }
        return true;
    }

    public function getVkUploadAttribute()
    {
        if (!is_null($this->tariff_id)) {
            $tariff = Tariff::where('id', $this->tariff_id)->first();
            return $tariff->is_vk_upload;
        }
        return true;
    }
}
