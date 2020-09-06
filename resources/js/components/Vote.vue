<template>
  <div>
      <button class="btn border mt-1" @click="like" >
            <span :class="{'text-primary' : liked}" >
              {{ likeCount | numeral('0a') }} like
            </span>
      </button>

      <button class="btn border mt-1" @click="unlike" >
            <span :class="{'text-primary' : unliked}" >
              {{ unLikeCount | numeral('0a') }} unlike
            </span>
      </button>

  </div>
</template>

<script>
//class="text-primary"
export default {

    props : ['default_votes','entity_id'], //entity_id soit video_id soit comment_id
    data()
    {
        return {
            votes : this.default_votes,
            likeCount : 0,
            unLikeCount : 0,
            liked : false,
            unliked : false,
        }
    },
    created()
    {
        var id = localStorage.getItem('userId');
        this.votes.forEach(vote => {

            if(vote.user_id === id) {

                vote.type === 'up' ? this.liked = true : this.unliked = true;
            }

            if(vote.type === 'up')
            {
                this.likeCount++;
            } else {
                this.unLikeCount++;
            }
        });
    },
    methods : {
        handle(err)
        {
            if(err.response.status === 401) {
                    if(confirm('you need to login to vote'))
                    {
                        window.location = '/login';
                    }
            }
        },
        vote(type)
        {

            const form = new FormData();
            form.append('type',type);

            axios.post(`/videos/${this.entity_id}/vote`,form)
            .then((res) => {

                if(res.status === 200) {
                    if(type === 'up') {
                        this.unLikeCount--;
                        this.unliked = false;
                        this.likeCount++;
                        this.liked =true;
                    } else {
                        this.unLikeCount++;
                        this.unliked = true;
                        this.likeCount--;
                        this.liked = false;
                    }
                } else if(res.status === 201) {
                    if(type === 'up')
                    {
                        this.likeCount++;
                        this.liked = true;
                    } else {
                        this.unLikeCount++;
                        this.unliked = true;
                    }

                }
            }).catch((err) => {
                this.handle(err);
                console.log(err.response.data)
            });
        },
        deleteVote(type)
        { // delete and update status 200 create status 201
            axios.delete(`/videos/${this.entity_id}/vote`)
            .then((res) => {
                    if(res.status === 200) {
                        if(type === 'up') {
                            this.likeCount--;
                            this.liked = false;
                        } else {
                            this.unLikeCount--;
                            this.unliked = false;
                        }
                    }
            }).catch((err) => {
               this.handle(err);
            });
        },
        like()
        {
            this.liked ? this.deleteVote('up') : this.vote('up')
        },
        unlike()
        {
            this.unliked ? this.deleteVote('down') : this.vote('down') ;
        }

    }





}
</script>

<style scoped >
button:hover
{
    background-color: lightgray;
}

</style>


