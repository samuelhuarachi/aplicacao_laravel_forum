class ListGirlTabsControl {

    constructor() {
        this.cam_girl_description_link = $("#btn_woman_list")
        this.cam_girl_photos_link = $("#btn_girl_list")

        this.cam_girl_description = $("#woman_list")
        this.cam_girl_photos = $("#girl_list")

        this.cam_girl_description_link.click(this.camGirlDescriptionLinkClick.bind(
            null,
            this.cam_girl_description_link,
            this.cam_girl_photos_link,
            this.cam_girl_description,
            this.cam_girl_photos,
        ))

        this.cam_girl_photos_link.click(this.camGirlPhotosLink.bind(
            null,
            this.cam_girl_description_link,
            this.cam_girl_photos_link,
            this.cam_girl_description,
            this.cam_girl_photos))

        this.firsConfig()
    }

    firsConfig() {
        this.cam_girl_description_link.addClass("active")
        this.cam_girl_photos_link.removeClass("active")

        this.cam_girl_description.show()
        this.cam_girl_photos.hide()
    }

    camGirlDescriptionLinkClick(
        cam_girl_description_link,
        cam_girl_photos_link,
        cam_girl_description,
        cam_girl_photos
    ) {
        cam_girl_description_link.addClass("active")
        cam_girl_photos_link.removeClass("active")

        cam_girl_description.show()
        cam_girl_photos.hide()
    }

    camGirlPhotosLink(
        cam_girl_description_link,
        cam_girl_photos_link,
        cam_girl_description,
        cam_girl_photos) {
        cam_girl_description_link.removeClass("active")
        cam_girl_photos_link.addClass("active")

        cam_girl_description.hide()
        cam_girl_photos.show()
    }
}

module.exports = {
    ListGirlTabsControl
}
