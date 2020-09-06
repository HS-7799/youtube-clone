<template>
    <div class="ml-5" >
        <div v-for="reply in replies.data" :key="reply.id" >
            <h6 class="mb-0" >
                <avatar :username="userName(reply.user)" :size="40" :customStyle="{display : 'inline-block'}" ></avatar>
                <strong>
                     {{ reply.user == null ? "Null":reply.user.name }}
                </strong>
            </h6>
            <div class="ml-5" >
                <span>
                    {{ reply.body }}
                </span>
                <!-- <span id="toggleInput" @click="showInput = !showInput" >
                    {{ text }}
                </span> -->

                    <app-vote
                        :default_votes="reply.votes"
                        :entity_id="reply.id" ></app-vote>

                </div>

                <input v-if="showInput" autofocus  type="text" class="form-control mr-1">

            </div>
            <div v-if="comment.replyCount > 0 && replies.next_page_url "  class="text-center">
                <a href="" @click.prevent="fetchReplies" >Load replies</a>
            </div>
        </div>

    </div>
</template>

<script>
import Avatar from 'vue-avatar'
export default {
    props : ['comment'],
    data() {
        return {
            showInput : false,
            replies : {
                data : [],
                next_page_url : `/comments/${this.comment.id}/replies`
            },

        }
    },
    components: {
        Avatar
    },
    methods : {
        fetchReplies()
        {

            axios.get(this.replies.next_page_url)
            .then((res) => {
                this.replies = {
                    ...res.data,
                    data : [
                        ...this.replies.data,
                        ...res.data.data
                    ]
                }
            })

        },
        userName(user)
        {
            return user == null ? 'Null' : user.name;
        },
        addNewReply(reply)
        {
            this.replies.data.unshift(reply)
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
