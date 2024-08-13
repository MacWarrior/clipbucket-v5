$(function () {

    document.querySelectorAll('.default-slider').forEach(function(defaultslider){

        let number_of_block = 3;

        let slider = defaultslider.querySelector('.slider-container-overflow');
        let miniatures = slider.querySelectorAll('.slider-video-container, .item-video');

        let conteneurRect = slider.getBoundingClientRect();
        let first_miniature = window.getComputedStyle(miniatures[0]);
        let paddingSum = parseInt(first_miniature.getPropertyValue('margin-left').replace('px', '')) + parseInt(first_miniature.getPropertyValue('margin-right').replace('px', ''));

        let new_width = Math.floor( ( conteneurRect.width / ( number_of_block + 0.5 ) ) - (paddingSum) - (paddingSum)/number_of_block );
        defaultslider.style.setProperty('--width', new_width+'px');
        let decalage = (new_width*0.25) + (paddingSum);

        slider.addEventListener("scroll", function(event){
            let scroll_left = event.target.scrollLeft;
            if(scroll_left <= 1) {
                defaultslider.querySelector('.slider-container-action .prev').style.display = 'none';
            } else {
                defaultslider.querySelector('.slider-container-action .prev').style.display = 'block';
            }

            if(scroll_left + conteneurRect.width >= slider.querySelector('.slider-container').offsetWidth ) {
                defaultslider.querySelector('.slider-container-action .next').style.display = 'none';
            } else {
                defaultslider.querySelector('.slider-container-action .next').style.display = 'block';
            }
        });
        slider.dispatchEvent(new CustomEvent('scroll'));

        defaultslider.querySelector('.slider-container-action .next').addEventListener('click', function(){
            let conteneurRect = slider.getBoundingClientRect();
            for (let i = 0; i < miniatures.length; i++) {
                let miniature = miniatures[i];
                let rect = miniature.getBoundingClientRect();
                if (rect.right > conteneurRect.right) {
                    slider.scrollLeft += rect.left - conteneurRect.left - decalage;
                    break;
                }
            }
        });

        defaultslider.querySelector('.slider-container-action .prev').addEventListener('click', function() {
            let conteneurRect = slider.getBoundingClientRect();
            for (let i = 0; i < miniatures.length; i++) {
                let miniature = miniatures[i];
                let rect = miniature.getBoundingClientRect();
                if (
                     rect.left + slider.scrollLeft - conteneurRect.left > slider.scrollLeft - conteneurRect.width + decalage
                ) {
                    slider.scrollLeft += rect.left - conteneurRect.left - decalage;
                    break;
                }
            }
        });
    })

});
