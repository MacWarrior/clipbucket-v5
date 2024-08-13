$(function () {

    document.querySelectorAll('.default-slider').forEach(function(defaultslider){

        let slider = defaultslider.querySelector('.slider-container-overflow');
        let miniatures = slider.querySelectorAll('.slider-video-container');
        let remInPixels = parseFloat(getComputedStyle(document.documentElement).fontSize)*2;

        defaultslider.querySelector('.slider-container-action .next').addEventListener('click', function(){
            let conteneurRect = slider.getBoundingClientRect();
            for (let i = 0; i < miniatures.length; i++) {
                let miniature = miniatures[i];
                let rect = miniature.getBoundingClientRect();
                if (rect.right > conteneurRect.right) {
                    slider.scrollLeft += rect.left - conteneurRect.left - remInPixels;
                    break;
                }
            }
        });

        defaultslider.querySelector('.slider-container-action .prev').addEventListener('click', function() {
            let conteneurRect = slider.getBoundingClientRect();
            for (let i = 0; i < miniatures.length; i++) {
                let miniature = miniatures[i];
                let rect = miniature.getBoundingClientRect();

                if ( (rect.left + conteneurRect.width ) > 0 ) {
                    slider.scrollLeft += rect.left - conteneurRect.left - remInPixels;
                    break;
                }
            }
        });
    })

});
