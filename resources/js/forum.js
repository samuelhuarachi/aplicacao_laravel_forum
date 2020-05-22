const axios = require('axios')


async function bannerOnlineGirls() {


    let response = await axios.get(BASEURL + '/api/client/online-girls')
        .then(function (response) {
            return response.data
        })
        .catch(function (error) {
            throw new Error(error.response.data.message)
        })


    console.log(response)
    let output = "";
    response.forEach(function (data) {
        let block = `<div class="girl_banner1">
        <a href="/camstream/client/${data.slug}">
        <img class="banner1_icon_camera" src="/images/camera2.png" />
        <img src="/images/modelos/${data.photo}" />
        <span><i class="icon-circle"></i> Online</span>
        </a>
        </div>`
        output = output + block
    })

    console.log(response)
    console.log("dsfasd")
    $("#banner_online_girls").html(output)
}


bannerOnlineGirls()
