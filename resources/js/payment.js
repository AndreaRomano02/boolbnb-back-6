const form = document.getElementById("payment-form");
const submit = document.getElementById("submit");
const nonce = document.getElementById("nonce");

braintree.client.create(
    {
        authorization: "sandbox_yk9tjp4q_zkvj7pnw8fkt9cv8",
    },
    function (err, clientInstance) {
        if (err) {
            console.error(err);
            return;
        }

        braintree.hostedFields.create(
            {
                client: clientInstance,
                styles: {
                    input: {
                        // change input styles to match
                        // bootstrap styles
                        "font-size": "1rem",
                        color: "#495057",
                    },
                },
                fields: {
                    cardholderName: {
                        container: "#card-name",
                        placeholder: "Name as it appears on your card",
                    },
                    number: {
                        container: "#card-number",
                        placeholder: "4111 1111 1111 1111",
                    },
                    cvv: {
                        container: "#cvv",
                        placeholder: "123",
                    },
                    expirationDate: {
                        container: "#expiration-date",
                        placeholder: "MM / YY",
                    },
                },
            },
            function (hostedFieldsErr, hostedFieldsInstance) {
                if (hostedFieldsErr) {
                    console.error(hostedFieldsErr);
                    return;
                }

                form.addEventListener(
                    "submit",
                    (event) => {
                        event.preventDefault();

                        hostedFieldsInstance.tokenize(function (
                            tokenizeErr,
                            payload
                        ) {
                            if (tokenizeErr) {
                                console.error(tokenizeErr);
                                return;
                            }
                            nonce.value = payload.nonce;
                            console.log(form);
                            form.submit();
                        });
                    },
                    false
                );
            }
        );
    }
);
