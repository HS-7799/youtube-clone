<template>
    <div>
            <div  class="mt-1" >
                <h6 class="mb-0" >
                    <avatar :username="comment.user.name" :size="40" :customStyle="{display : 'inline-block'}" ></avatar>
                    <strong>
                        {{ comment.user.name }}
                    </strong>
                </h6>
                <div class="ml-5" >
                    <span>
                        {{ comment.body }}
                    </span>
                    <span id="toggleInput" @click=" showInput = ! showInput" >
                        {{ text }}
                    </span>

                    <app-vote
                        :default_votes="comment.votes"
                        :entity_id="comment.id" ></app-vote>
                    <form v-if=" showInput"  @submit.prevent="addReply" class="form-inline mt-1" >
                        <input type="text" required v-model="form.body" class="form-control">
                        <button class="btn btn-primary" type="submit">Add reply</button>
                    </form>
                    <p class="text-danger" v-if="errors.body">{{ errors.body[0] }}</p>
                </div>


            </div>

            <app-replies ref="addReply"  :comment="comment" ></app-replies>
    </div>
</template>

<script>
import Avatar from 'vue-avatar'
import Replies from './Replies.vue'
import Vote from './Vote.vue'
export default {
    props : ['video_id','comment'],
    data() {
        return {
            form : {
                body : null,
                comment_id : this.comment.id
            },
            errors : {},
            showInput : false
        }

    },
    components : {
        appReplies : Replies,
        Avatar,
        appVote : Vote
    },
    methods : {

        addReply()
        {
            axios.post(`/comments/${this.video_id}`,this.form)
            .then((res) => {
                this.errors = {}
                this.form.body = null
                this.showInput = false
                this.$refs.addReply.addNewReply(res.data)
            })
            .catch((err) => {
                console.log(err.response.data)
                if(err.response.status === 401)
                {
                    if(confirm('you need to login'))
                    {
                        window.location = '/login'
                    }
                }
                if(err.response.data.errors)
                {
                    this.errors = err.response.data.errors
                }
            })
        }
    },
    computed: {
        text()
        {
            return this.showInput ? 'Cancel' : 'Reply';
        },

    }
}

</script>


<style scoped >
#toggleInput
{
    cursor:pointer;
    text-decoration : underline;
    color : lightblue;
}
</style>
