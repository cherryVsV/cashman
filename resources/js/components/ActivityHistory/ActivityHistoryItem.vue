<template>
    <fragment>
        <div class="detail">
            <img :src="'assets/sample/'+activity.company.image" alt="img" class="image-block imaged w48">
            <div>
                <strong>{{ activity.company.title }}</strong>
                <p v-if="activity.type['ru']==='Начисление'">{{$trans('strings.Accrual of cashback to the user')}} {{activity.user.name}}</p>
                <p v-if="activity.type['ru']==='Списание'">{{$trans('strings.Debiting cashback from the user')}} {{activity.user.name}}</p>
            </div>
        </div>
        <div class="right">
            <div v-if="activity.type['ru']==='Начисление'" class="price text-danger">+{{ activity.value }}$</div>
            <div v-if="activity.type['ru']==='Списание'" class="price text-black-50">-{{ activity.value }}$</div>
        </div>
    </fragment>
</template>

<script>
export default {
    name: "ActivityHistoryItem",
    props: {
        activity: {
            required: true,
            type: Object
        }
    }
}
</script>
