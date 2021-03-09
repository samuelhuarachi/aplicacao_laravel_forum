class CamgirlTabs {

    constructor() {
        this.cam_girl_description_link = $("#cam_girl_description_link")
        this.cam_girl_photos_link = $("#cam_girl_photos_link")
        this.cam_girl_videos_link = $("#cam_girl_videos_link")

        this.cam_girl_description = $("#cam_girl_description")
        this.cam_girl_photos = $("#cam_girl_photos")
        this.cam_girl_videos = $("#cam_girl_videos")

        this.cam_girl_description_link.click(this.camGirlDescriptionLinkClick.bind(
            null,
            this.cam_girl_description_link,
            this.cam_girl_photos_link,
            this.cam_girl_videos_link,
            this.cam_girl_description,
            this.cam_girl_photos,
            this.cam_girl_videos))

        this.cam_girl_photos_link.click(this.camGirlPhotosLink.bind(
            null,
            this.cam_girl_description_link,
            this.cam_girl_photos_link,
            this.cam_girl_videos_link,
            this.cam_girl_description,
            this.cam_girl_photos,
            this.cam_girl_videos))

        this.cam_girl_videos_link.click(this.camGirlVideosLink.bind(
            null,
            this.cam_girl_description_link,
            this.cam_girl_photos_link,
            this.cam_girl_videos_link,
            this.cam_girl_description,
            this.cam_girl_photos,
            this.cam_girl_videos))

        this.firsConfig()
    }

    firsConfig() {
        this.cam_girl_description_link.removeClass("active")
        this.cam_girl_photos_link.addClass("active")
        this.cam_girl_videos_link.removeClass("active")

        this.cam_girl_description.show()
        this.cam_girl_photos.hide()
        this.cam_girl_videos.hide()
    }

    camGirlDescriptionLinkClick(
        cam_girl_description_link,
        cam_girl_photos_link,
        cam_girl_videos_link,
        cam_girl_description,
        cam_girl_photos,
        cam_girl_videos
    ) {
        cam_girl_description_link.addClass("active")
        cam_girl_photos_link.removeClass("active")
        cam_girl_videos_link.removeClass("active")

        cam_girl_description.show()
        cam_girl_photos.hide()
        cam_girl_videos.hide()
    }

    camGirlPhotosLink(
        cam_girl_description_link,
        cam_girl_photos_link,
        cam_girl_videos_link,
        cam_girl_description,
        cam_girl_photos,
        cam_girl_videos) {
        cam_girl_description_link.removeClass("active")
        cam_girl_photos_link.addClass("active")
        cam_girl_videos_link.removeClass("active")

        cam_girl_description.hide()
        cam_girl_photos.show()
        cam_girl_videos.hide()
    }

    camGirlVideosLink(
        cam_girl_description_link,
        cam_girl_photos_link,
        cam_girl_videos_link,
        cam_girl_description,
        cam_girl_photos,
        cam_girl_videos
    ) {
        cam_girl_description_link.removeClass("active")
        cam_girl_photos_link.removeClass("active")
        cam_girl_videos_link.addClass("active")

        cam_girl_description.hide()
        cam_girl_photos.hide()
        cam_girl_videos.show()
    }

}

module.exports = {
    CamgirlTabs
}
