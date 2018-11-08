if (notyMessage) {
    new Noty({
        type: notyType,
        layout: "topRight",
        theme: 'bootstrap-v4',
        timeout: 2000,
        progressBar: true,
        text: notyMessage,
        container: '.notyDiv'
    }).show();
}