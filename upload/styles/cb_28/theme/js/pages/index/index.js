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


    class SliderFeatured {
        constructor(container) {
            this.slidesContainerMain = container;
            this.slidesContainer = this.slidesContainerMain.querySelector('.slides');

            // Extraction des valeurs à partir des attributs data-* dans le HTML
            this.animationTime = parseInt(this.slidesContainerMain.dataset.animationTime) || 300;
            this.timerAutoNext = parseInt(this.slidesContainerMain.dataset.timerAutoNext) || 5000;
            this.visibleSlides = parseInt(this.slidesContainerMain.dataset.nbLeft) || 1;
            this.main_height = this.slidesContainerMain.dataset.heightSlider ?? '300px';

            if( isNaN(this.visibleSlides) || this.visibleSlides < 0) {
                this.visibleSlides = 0;
            }

            if( isNaN(this.animationTime) || this.animationTime < 0) {
                this.animationTime = 0;
            }

            this.isAnimating = false;
            this.initialize();
        }

        initialize() {
            this.updateSlideListeners();
            this.addNavigationButtons(); // Méthode pour gérer les boutons de navigation
            this.initializeResizeObserver(); // Initialise le ResizeObserver

            const slideCount = this.slidesContainer.children.length;
            if (slideCount === 0) {
                this.slidesContainerMain.style.display = 'none';
            } else if (slideCount === 1) {
                this.scrollToSlide(0);
            } else {
                const initialIndex = slideCount >= this.visibleSlides ? this.visibleSlides : 1;
                this.scrollToSlide(initialIndex);
            }

            this.slidesContainerMain.style.setProperty('--height-slider-featured', this.main_height);
            this.slidesContainerMain.style.setProperty('--animation-time', this.animationTime+'ms');


            let instance = this;
            this.slidesContainerMain.addEventListener('mouseover', function() {
                clearInterval(instance.interval); // Arrête l'intervalle quand la souris survole l'élément
            });

            this.slidesContainerMain.addEventListener('mouseleave', function() {
                instance.resetTimer(); // Réinitialise le timer quand la souris sort de l'élément
            });

        }

        resetTimer() {

            if(this.getNumberOfSlides() <= 1) {
                return ;
            }

            let instance = this;
            clearInterval(this.interval)
            this.interval = setInterval(function(){
                instance.nextSlide();
            },this.timerAutoNext+this.animationTime);
        }

        // Méthode pour récupérer la valeur calculée d'une variable CSS
        getComputedCSSVariable(variableName) {
            const tempElement = document.createElement('div');
            tempElement.style.position = 'absolute';
            tempElement.style.visibility = 'hidden';
            tempElement.style.width = 'var('+variableName+')';
            this.slidesContainerMain.appendChild(tempElement);
            const computedValue = getComputedStyle(tempElement).width;
            this.slidesContainerMain.removeChild(tempElement);
            return parseFloat(computedValue);
        }

        getNumberOfSlides() {
            return this.slidesContainer.children.length; // Compte les enfants (slides) du conteneur
        }

        initializeResizeObserver() {
            const observer = new ResizeObserver(entries => {
                const widthPoster = this.getComputedCSSVariable('--width-poster-base');
                const widthThumb = this.getComputedCSSVariable('--width-thumb');
                const widthCollapsed = this.getComputedCSSVariable('--width-collapsed');
                const totalRequiredWidth = widthPoster + widthThumb + ((1+this.visibleSlides) * widthCollapsed);

                for (let entry of entries) {
                    const width = entry.contentRect.width;
                    /** @todo ca particulier si moin de 2 ou 3 images */
                    if (width <= totalRequiredWidth && this.getNumberOfSlides() >= 1+parseInt(this.visibleSlides)) {
                        console.log(width+' < '+ totalRequiredWidth)
                        console.log(this.getNumberOfSlides()+' >= '+ (1+parseInt(this.visibleSlides)))
                        this.slidesContainerMain.classList.add('without_poster');
                    } else {
                        this.slidesContainerMain.classList.remove('without_poster');
                    }

                    const rect = this.slidesContainerMain.getBoundingClientRect();
                    const rect2 = this.slidesContainer.getBoundingClientRect();

                    if (rect2.width > rect.width && this.isAnimating === false) {
                        const slides = Array.from(this.slidesContainer.children);
                        if(slides[this.visibleSlides] !== undefined) {
                            console.log("mode slide")
                            const slides = Array.from(this.slidesContainer.children);
                            const targetIndex = slides.findIndex(slide => slide.classList.contains('active'));
                            this.clearActiveSlide();
                            slides[this.visibleSlides].classList.add('active');
                            this.scrollToSlide(targetIndex)
                        }
                        return ;
                    }

                }
            });

            observer.observe(this.slidesContainerMain);
        }

        getCurrentSlideActive() {
            const slides = Array.from(this.slidesContainer.children);
            const activeSlide = slides.find(slide => slide.classList.contains('active'));
            return activeSlide ? slides.indexOf(activeSlide) : 0;
        }

        nextSlide() {
            const slideCount = this.slidesContainer.children.length;  // Nombre total de slides
            const nextIndex = (this.getCurrentSlideActive() + 1) % slideCount;  // Retour au premier après le dernier
            this.scrollToSlide(nextIndex);
        }

        prevSlide() {
            const slideCount = this.slidesContainer.children.length;  // Nombre total de slides
            const prevIndex = (this.getCurrentSlideActive() - 1 + slideCount) % slideCount;  // Retour au dernier après le premier
            this.scrollToSlide(prevIndex);
        }

        addNavigationButtons() {
            const nextButton = this.slidesContainerMain.querySelector('.next-btn');
            const prevButton = this.slidesContainerMain.querySelector('.prev-btn');

            if (nextButton) {
                nextButton.addEventListener('click', () => this.nextSlide());
            }

            if (prevButton) {
                prevButton.addEventListener('click', () => this.prevSlide());
            }
        }

        moveXSlideToEnd(slides, targetIndex, currentIndex) {

            if (currentIndex === 0) {
                this.clearActiveSlide();
                slides[targetIndex].classList.add('active');
            }
            if (targetIndex === currentIndex + this.visibleSlides) {
                this.isAnimating = false;  // Libère le verrou
                return;
            }

            try {

                const elem = slides[currentIndex];
                elem.classList.remove('active');
                this.slidesContainer.appendChild(elem.cloneNode(true));
                elem.classList.add('removeAnimation');
                let t = this.animationTime / this.visibleSlides;

                if (currentIndex > 0) {

                    let diviseur = ( targetIndex - 3 );
                    if(diviseur <= 0) {
                        diviseur = 3
                    }

                    t= t/ diviseur;
                    if(t <= 75) {
                        t=75;
                    }
                }

                if(t === Infinity) {
                    t= 250;
                }

                this.slidesContainerMain.style.setProperty('--animation-time', t+'ms');

                elem.style.transition = `width `+t+`ms linear`;
                setTimeout(() => {
                    elem.remove();
                    elem.style.transition = '';
                    this.updateSlideListeners();
                    this.moveXSlideToEnd(slides, targetIndex, currentIndex + 1);
                }, t);

            }catch (e){
                this.isAnimating = false;  // Libère le verrou
                throw e
            }

        }

        moveXSlideToStart(slides, targetIndex, currentIndex) {

            if (currentIndex === this.slidesContainer.children.length - 1) {
                this.clearActiveSlide();
                slides[targetIndex].classList.add('active');
            }
            if (currentIndex === this.slidesContainer.children.length - 1 - (this.visibleSlides - targetIndex)) {
                this.isAnimating = false;  // Libère le verrou
                return;
            }

            try {
                const elem = slides[currentIndex];
                this.slidesContainer.insertBefore(elem, this.slidesContainer.firstElementChild);
                const t = this.animationTime / this.visibleSlides;
                elem.style.transition = `width `+t+`ms linear`;
                elem.classList.add('animate-slide-in');
                this.slidesContainerMain.style.setProperty('--animation-time', t+'ms');
                setTimeout(() => {
                    elem.classList.remove('animate-slide-in');
                    elem.style.transition = '';
                    this.updateSlideListeners();
                    this.moveXSlideToStart(slides, targetIndex, currentIndex - 1);
                }, t);

            }catch (e){
                this.isAnimating = false;  // Libère le verrou
                throw e
            }

        }

        scrollToSlide(targetIndex) {

            if (this.isAnimating) {
                return;// Empêche l'exécution si l'animation est en cours
            }
            this.isAnimating = true;  // Active le verrou d'animation

            this.resetTimer();

            const slides = Array.from(this.slidesContainer.children);
            const currentIndex = slides.findIndex(slide => slide.classList.contains('active'));
            const rect = this.slidesContainerMain.getBoundingClientRect();
            const rect2 = this.slidesContainer.getBoundingClientRect();

            if (rect2.width <= rect.width) {
                this.slidesContainerMain.style.setProperty('--animation-time', this.animationTime+'ms');
                this.clearActiveSlide();
                slides[targetIndex].classList.add('active');
                this.isAnimating = false;  // Libère le verrou
                return;
            }

            if (targetIndex > currentIndex) {
                this.moveXSlideToEnd(slides, targetIndex, 0);
            } else if (targetIndex < currentIndex) {
                this.moveXSlideToStart(slides, targetIndex, this.slidesContainer.children.length - 1);
            } else {
                this.isAnimating = false;  // Libère le verrou
            }
        }

        clearActiveSlide() {
            this.slidesContainer.querySelectorAll('.slide.active').forEach(slide => slide.classList.remove('active'));
        }

        updateSlideListeners() {
            const slides = Array.from(this.slidesContainer.children);
            slides.forEach((slide, index) => {
                slide.onclick = () => this.scrollToSlide(index);
            });
        }
    }

    document.querySelectorAll('.slider-container-featured').forEach(function(sliderElement){
        new SliderFeatured(sliderElement);
    })

});
