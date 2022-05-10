<template>
    <div class="section mb-3">
        <div class="card">
            <div class="card-body">
                <div class="p-1">
                    <div class="text-center">
                        <h2 class="text-primary">{{$trans('strings.Comment')}}</h2>
                        <p>{{$trans('strings.Leave your comment on the product')}}</p>
                    </div>
                    <form @keyup.enter="postComment" id="commentForm">
                        <div class="form-group basic animated">
                            <div class="input-wrapper">
                                <label class="label"
                                       for="name">{{ $trans('strings.Please provide your name.') }}</label>
                                <input v-model="comment.author" type="text" class="form-control" id="name"
                                       :placeholder="$trans('strings.Please provide your name.')">
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                            <!--<HasError :form="form" field="name"/>-->
                        </div>
                        <div class="form-group basic animated">
                            <div class="input-wrapper">
                                <label class="label" for="comment">{{$trans('strings.Your comment on the product')}}</label>
                                <textarea style="min-height:100px;" type="text" name="comment"
                                    id="comment" class="input is-medium form-control" v-model="comment.content"
                                    :placeholder="$trans('strings.Enter your comment')"></textarea>
                                <i class="clear-input">
                                    <ion-icon name="close-circle"></ion-icon>
                                </i>
                            </div>
                            <!--<HasError :form="form" field="name"/>-->
                        </div>
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary btn-lg btn-block" :disabled="!isValid"
                                    @click.prevent="postComment" :class="{'is-loading': submit}" form="commentForm"
                            >{{$trans('strings.Send')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "NewComment",
    props: ['id'],
    data() {
        return {
            submit: false,
            comment: {
                content: '',
                author: '',
                product_id: this.id
            }
        }
    },
    methods: {
        postComment() {
            this.submit = true;
            this.$store.dispatch('ADD_COMMENT', this.comment)
                .then(response => {
                    this.submit = false;
                    if (response.data === 'ok')
                        console.log('success')
                        this.comment.content = '';
                        this.comment.author = '';
                }).catch(err => {
                this.submit = false
            })

        },
    },
    computed: {
        isValid() {
            return this.comment.content !== '' && this.comment.author !== ''
        }
    }
}
</script>

<style scoped>
.has-margin-top {
    margin-top: 15px;
}

</style>
