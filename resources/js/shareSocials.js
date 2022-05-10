import JSShare from "js-share";
export const shareSocials = {
    methods: {
        share(idSelector) {
            let shareItems = document.querySelector(idSelector).querySelectorAll('a');
            for (let i = 0; i < shareItems.length; i += 1) {
                shareItems[i].addEventListener('click', function share(e) {
                    return JSShare.go(this);
                });
            }
        }

    }
}
