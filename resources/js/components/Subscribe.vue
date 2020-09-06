<template>
        <button type="submit" class="btn btn-danger" @click="toggleSubscription" >
            <span v-if="showSpiner" class="spinner-border spinner-border-sm"></span>
                {{ buttonText }} {{ count | numeral('0a') }}

        </button>
</template>

<script>
    export default {

        props : ['subscribed','id','owner','subscribers'],
        data() {
            return {
                status : this.subscribed,
                showSpiner : false,
                count : this.subscribers
            }
        },
        methods : {
            toggleSubscription()
            {
                if(!this.owner)
                {
                    this.showSpiner = true;
                    axios.post(`/channels/${this.id}/subscription`)
                    .then((response) => {
                        if(this.status)
                        {
                            this.count--;
                        }
                        else
                        {
                            this.count++;
                        }
                        this.status = !this.status;
                        this.showSpiner = false;
                    }).catch((err) => {
                        this.showSpiner = false;
                        if(err.response.status == 401)
                        {
                            window.location = "/login";
                        }
                    });
                }

            }
        },
        computed : {

            buttonText()
            {
                return this.owner ? 'Subscribers' : this.status ? 'Unsubscribe' : 'Subscribe';;
            }

        },
    }
</script>

<style>

</style>



<!--
<template>
    <div class="ml-auto" >
       <button class="btn btn-danger" @click="subscribe" >
           <span v-if="spiner" class="spinner-border spinner-border-sm"></span>
           {{ buttonText}} {{  numberOfSubscribers | numeralFormat('0a') }}
        </button>

    </div>
</template>
