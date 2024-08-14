$(function () {

    document.querySelectorAll('.default-slider').forEach(function(defaultslider){

        let number_of_block = 3;

        let slider = defaultslider.querySelector('.slider-container-overflow');
        let miniatures = slider.querySelectorAll('.slider-video-container, .item-video');

        let conteneurRect = slider.getBoundingClientRect();
        let first_miniature = window.getComputedStyle(miniatures[0]);
        let marginSum = parseInt(first_miniature.getPropertyValue('margin-left').replace('px', '')) + parseInt(first_miniature.getPropertyValue('margin-right').replace('px', ''));

        let new_width = Math.floor( ( conteneurRect.width / ( number_of_block + 0.5 ) ) - (marginSum) - (marginSum)/number_of_block ) ;
        defaultslider.style.setProperty('--width', new_width+'px');
        let decalage = (new_width*0.25) + (marginSum);

        let resetOpacity = function(){
            for (let i = 0; i < miniatures.length; i++) {
                let miniature = miniatures[i];
                miniature.classList.remove('disabled')
                miniature.classList.remove('disabled-prev')
                miniature.classList.remove('disabled-next')
            }
        }

        let setOpacity = function(){

            for (let i = 0; i < miniatures.length; i++) {
                let miniature = miniatures[i];
                let rect = miniature.getBoundingClientRect();
                if (rect.left < conteneurRect.left && rect.right > conteneurRect.left) {
                    miniature.classList.add('disabled')
                    miniature.classList.add('disabled-prev')

                    miniature.addEventListener('click', function(){
                        defaultslider.querySelector('.prev').dispatchEvent(new CustomEvent('click'));
                    })

                    break;
                }
            }
            for (let i = miniatures.length -1; i >= 0; i--) {
                let miniature = miniatures[i];
                let rect = miniature.getBoundingClientRect();
                if (rect.left < conteneurRect.right && rect.right > conteneurRect.right) {
                    miniature.classList.add('disabled')
                    miniature.classList.add('disabled-next')

                    miniature.addEventListener('click', function(){
                        defaultslider.querySelector('.next').dispatchEvent(new CustomEvent('click'));
                    })

                    break;
                }
            }

        }

        let timeout = null;
        slider.addEventListener("scroll", function(event){

            if(timeout !== null) {
                clearTimeout(timeout);
            }

            timeout = setTimeout(function(){
                resetOpacity();
                setOpacity();

                slider.classList.remove('scrolling')
                clearTimeout(timeout);
            }, 100);

        });
        slider.dispatchEvent(new CustomEvent('scroll'));

        defaultslider.querySelector('.slider-container-action .next').addEventListener('click', function(){
            let conteneurRect = slider.getBoundingClientRect();
            for (let i = 0; i < miniatures.length; i++) {
                let miniature = miniatures[i];
                let rect = miniature.getBoundingClientRect();
                if (rect.right > conteneurRect.right) {
                    slider.classList.add('scrolling')
                    resetOpacity();
                    slider.scrollLeft += rect.left - conteneurRect.left - decalage;
                    console.log(slider.scrollLeft+rect.left - conteneurRect.left - decalage)
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
                    slider.classList.add('scrolling')
                    resetOpacity();
                    slider.scrollLeft += rect.left - conteneurRect.left - decalage;
                    break;
                }
            }
        });
    })

});
