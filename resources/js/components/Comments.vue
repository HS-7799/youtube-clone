<template>
    <div>
        <form  @submit.prevent="addComment" class="form-inline" >
            <input type="text" required v-model="form.body" class="form-control">
            <button class="btn btn-primary" type="submit">Add comment</button>
        </form>
        <p class="text-danger" v-if="errors.body">{{ errors.body[0] }}</p>
        <div class="comment" v-for="comment in comments.data" :key="comment.id" >
            <app-comment :comment="comment" :video_id="video_id" ></app-comment>
        </div>
        <div  class="text-center" v-if="comments.next_page_url" >
            <span id="loadComments" @click="fetchComments" >See more comments</span>
        </div>
    </div>
</template>

<script>
import Avatar from 'vue-avatar'
import Replies from './Replies.vue'
import Vote from './Vote.vue'
import Comment from './Comment.vue'
export default {
    props : ['video_id'],
    data() {
        return {
            comments : {
                data : []
            },
            form : {
                body : null
            },
            errors : {}
        }

    },
    components : {
        appReplies : Replies,
        Avatar,
        appVote : Vote,
        appComment : Comment
    },
    methods : {
        fetchComments()
        {
            const url = this.comments.next_page_url ? this.comments.next_page_url : `/videos/${this.video_id}/comments`;

            axios.get(url)
            .then((res) => {
                this.comments = {
                    ...res.data,
                    data : [
                        ...this.comments.data,
                        ...res.data.data
                    ]
                }
            })
        },
        addComment()
        {
            axios.post(`/comments/${this.video_id}`,this.form)
            .then((res) => {
                this.errors = {}
                this.form.body = null
                this.comments.data.unshift(res.data)
            })
            .catch((err) => {
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
    created()
    {
        this.fetchComments()
    }
}

</script>




<style scoped >
#loadComments
{
    cursor : pointer;
    color : lightblue;
}

#loadComments:hover
{
    text-decoration : underline;

}
</style>
