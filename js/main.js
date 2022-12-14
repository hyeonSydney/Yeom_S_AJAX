import { SendMail } from "./components/mailer.js";

(() => {
    const { createApp } = Vue

    createApp({
        data() {
            return {
                message: 'Hello Vue!'
            }
        },

        methods: {
            processMailFailure(result) {
                // show a failure message in the UI
                // use this.$refs to connect to the elements on the page and mark any empty blanks/inputs with an error class
                // alert('failure! and if you keep using an alert, DOUBLE failure!');
                // show some errors in the UI here to let the user know the mail attempt was successful
                // DO NOT USE THIS ALERT METHOD. or it's a big fat 0

                let result = JSON.parse(result.message).message;
                // let field = JSON.parse(result.message).message;

                let error = document.querySelector('.sendForm_error');
                error.classList.add('.error');

                result.forEach(element);
                this.$refs["errorEmpty"].innerHTML = result.message;
                this.$refs["errorEmpty"].style.display = 'block';
                this.$refs["successBox"].style.display = 'none';
                
                function element() {
                    this.$refs.classList.add("error");
                }
                // if(result.field) {
                //     result.field.forEach(element => {
                //         this.$refs.classList.add("error");
                //     });
                // }
            },

            processMailSuccess(result) {
                // show a success message in the UI
                // alert("success! but don't EVER use alerts. They are gross.");
                // show some UI here to let the user know the mail attempt was successful
                // DO NOT USE THIS ALERT METHOD. or it's a big fat 0
                // use a different method of showing mail success. Get creative with it.

                this.$refs["successBox"].innerHTML = result.message;
                this.$refs["successBox"].style.display = 'block';
                this.$refs["errorEmpty"].style.display = 'none';

                this.$refs["submit"].disabled = true;
                // document.querySelector(".submitBtn").value = "Thank You!";
                // document.querySelector('input').style.color = 'blue';
            },

            processMail(event) {
                // use the SendMail component to process mail
                SendMail(this.$el.parentNode)
                    .then(data => this.processMailSuccess(data))
                    .catch(err => this.processMailFailure(err));
            }
        }
    }).mount('#mail-form')
})();