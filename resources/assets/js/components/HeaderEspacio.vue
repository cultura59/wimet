<template>
    <div>
        <header class="home-espacio-header cursor-pointer" id="imagen-principal" v-on:click="openModal();currentSlide(1)">
            <button class="home-espacio-header__boton" v-on:click="openModal();currentSlide(1)">VER FOTOS</button>
        </header>

        <div id="imagesModal" class="imagesModal">
            <span class="close-header cursor" v-on:click="closeModal()">&times;</span>
            <div class="imagesModal__content">
                <div v-if="(image360 !== null)" class="imagesModal__content__mySlides">
                  <iframe :src="image360" frameborder="0" width="100%" height="620"></iframe>
                </div>
                <div class="imagesModal__content__mySlides" v-for="img in images">
                    <img :src="urlImagen(img.name)" style="width: auto; height: 620px">
                </div>

                <a class="prev" v-on:click="plusSlides(-1)">&#10094;</a>
                <a class="next" v-on:click="plusSlides(1)">&#10095;</a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'espacioId'
        ],
        data() {
            return {
              slideIndex: 1,
              images: [],
              image360: null
            }
        },
        mounted() {
            this.getImagenesEspacio();
        },
        ready() {
            this.showSlides(this.slideIndex);
        },
        methods: {
            getImagenesEspacio() {
                this.$http.get(`/api/espacio/${this.espacioId}`)
                .then(res => {
                    this.image360 = res.body.image360;
                    this.images = res.body.images;
                    document.getElementById('imagen-principal').style.backgroundImage = `url(${this.urlImagen(this.images[0].name)})`;
                }, err => {
                    console.log(err);
                });
            },
            urlImagen(url) {
              return `https://res.cloudinary.com/wimet/image/upload/q_60/${url}`;
            },
            openModal() {
                document.getElementById('imagesModal').style.display = "block";
            },
            closeModal() {
                document.getElementById('imagesModal').style.display = "none";
            },
            showSlides(n) {
                let i;
                let slides = document.getElementsByClassName("imagesModal__content__mySlides");
                
                if (n > slides.length) {this.slideIndex = 1}
                if (n < 1) {this.slideIndex = slides.length}

                for (i = 0; i < slides.length; i++) {
                    slides[i].style.display = "none";
                }
                slides[this.slideIndex-1].style.display = "block";
            },
            plusSlides(n) {
                this.showSlides(this.slideIndex += n);
            },
            currentSlide(n) {
                this.showSlides(this.slideIndex = n);
            }
        }
    }
</script>

<style lang="sass">
    .imagesModal {
      display: none;
      position: fixed;
      z-index: 10000;
      padding-top: 10px;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0, 0, 0, 0.87);
      &__content {
        position: relative;
        margin: 0 auto;
        padding: 0;
        max-width: 1200px;
        box-shadow: none;
        border: none;
        &__mySlides {
          display: none;
          text-align: center;
        }
      }
    }
    .close-header {
      color: #fff;
      position: absolute;
      top: 0;
      right: 10px;
      font-size: 30px;
      font-weight: bold;
    }
    .close-header:hover, .close-header:focus {
      color: #999;
      text-decoration: none;
      cursor: pointer;
    }
    .prev, .next {
      cursor: pointer;
      position: absolute;
      top: 50%;
      width: auto;
      padding: 16px;
      margin-top: -50px;
      color: white;
      font-weight: bold;
      font-size: 20px;
      transition: 0.6s ease;
      border-radius: 0 3px 3px 0;
      user-select: none;
      -webkit-user-select: none;
    }
    .next {
      right: 0;
      border-radius: 3px 0 0 3px;
    }
    .prev:hover, .next:hover {
      text-decoration: none;
    }
    .caption-container {
      text-align: center;
      background-color: black;
      padding: 2px 16px;
      color: white;
    }
    .active {
      opacity: 1;
    }
</style>