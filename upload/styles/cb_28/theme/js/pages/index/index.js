$(function () {

    document.querySelectorAll('.default-slider').forEach(function(defaultslider){
        let last_first_item = null;

        let ratio = defaultslider.getAttribute('data-ratio') ?? 1;

        let slider = defaultslider.querySelector('.slider-container-overflow');
        let miniatures = slider.querySelectorAll('.slider-video-container, .item-video');

        if(miniatures.length === 0) {
            return ;
        }

        let conteneurRect = slider.getBoundingClientRect();
        let first_miniature = window.getComputedStyle(miniatures[0]);
        let marginSum = parseInt(first_miniature.getPropertyValue('margin-left').replace('px', '')) + parseInt(first_miniature.getPropertyValue('margin-right').replace('px', ''));

        let decalage = 0;
        let resizeMe = function(ratio){

            conteneurRect = slider.getBoundingClientRect();

            let height_fixe = 150;
            let fake_width = height_fixe * ratio;

            let number_of_block_brut = (conteneurRect.width / fake_width) - 0.5;
            let number_of_block = Math.floor(number_of_block_brut);

            if(number_of_block <= 0) {
                number_of_block = 1;
            }

            let new_width = Math.floor( ( conteneurRect.width / ( number_of_block + 0.5 ) ) - (marginSum) - (marginSum)/number_of_block ) ;

            let new_height = new_width / ratio

            defaultslider.style.setProperty('--width', new_width+'px');
            defaultslider.style.setProperty('--height', new_height+'px');
            decalage = (new_width*0.25) + (marginSum);
        }

        resizeMe(ratio);

        let old_value = null;
        setInterval(function(){
            if(slider.offsetWidth === old_value) {
                return ;
            }
            old_value = slider.offsetWidth;

            resizeMe(ratio);

            if(last_first_item !== null){
                let rect = last_first_item.getBoundingClientRect();
                slider.classList.add('scrolling')
                resetOpacity();
                slider.scrollLeft += rect.left - conteneurRect.left - decalage;
            }

            slider.dispatchEvent(new CustomEvent('scroll'));
        }, 400)

        let resetOpacity = function(){
            for (let i = 0; i < miniatures.length; i++) {
                let miniature = miniatures[i];
                miniature.classList.remove('disabled')
                miniature.classList.remove('disabled-prev')
                miniature.classList.remove('disabled-next')
                miniature.removeAttribute('title')
            }
        }

        let prevListenerCallback = function(){
            defaultslider.querySelector('.prev').dispatchEvent(new CustomEvent('click'));
            this.removeEventListener("click", prevListenerCallback);
        };

        let nextListenerCallback = function(){
            defaultslider.querySelector('.next').dispatchEvent(new CustomEvent('click'));
            this.removeEventListener("click", nextListenerCallback);
        };

        let setOpacity = function(){

            for (let i = 0; i < miniatures.length; i++) {
                let miniature = miniatures[i];
                let rect = miniature.getBoundingClientRect();
                if (rect.left < conteneurRect.left && rect.right > conteneurRect.left) {
                    miniature.classList.add('disabled')
                    miniature.classList.add('disabled-prev')
                    if(previousLang !== undefined) {
                        miniature.setAttribute('title', previousLang)
                    }
                    miniature.addEventListener('click', prevListenerCallback)
                    break;
                }
            }
            for (let i = miniatures.length -1; i >= 0; i--) {
                let miniature = miniatures[i];
                let rect = miniature.getBoundingClientRect();
                if (rect.left < conteneurRect.right && rect.right > conteneurRect.right) {
                    miniature.classList.add('disabled')
                    miniature.classList.add('disabled-next')
                    if(nextLang !== undefined) {
                        miniature.setAttribute('title', nextLang)
                    }
                    miniature.addEventListener('click', nextListenerCallback)
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
                    last_first_item = miniature;
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
                    last_first_item = miniature;
                    break;
                }
            }
        });
    })

});
