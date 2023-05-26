export default class Confirmation {
    constructor(options) {
        this.options = options || {};
        this.confirm();
    }

    confirm() {
        let route = this.options.route;
        $.confirm({
            title: this.options.title,
            type: "red",
            theme: "supervan",
            content: "Emin misiniz?",
            buttons: {
                evet: {
                    text: "Evet",
                    action: function() {
                        axios.delete(route)
                            .then(response => {
                                document.location.href = response.data.url;
                            })
                            .catch(error => {
                                let errors = '';
                                if(error.response.data.errors.authorization) {
                                    errors += "<p>- "+error.response.data.errors.authorization[0]+"</p>";
                                }
                                $.alert(errors);
                            });
                    }
                },
                iptal: {
                    text: "Hayır",
                    action: function() {

                    }
                }
            },

        })
    }
}
