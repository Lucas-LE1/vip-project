<template id="template_search">
  <div class="template_search">
    <header class="header_search">
      <div class="div_search">
        <div class="texts">
      <span class="find_message">
        find your movie
        </span>
          <div class="title">
            <h1 class="title_page_search">
              find the
            </h1>
            <h1 class="title_page_search contrast">best movie</h1>
          </div>
        </div>
        <div class="input_div">
          <div class="img_input">
            <img src="../icons/search.svg" alt="" class="icon"/>
            <input v-model="this.search" type="text" class="input_search" placeholder="Find by name or synopsis">
          </div>
          <button @click="this.navigateList(this.search)" class="button_search">Search now</button>
        </div>
      </div>
      <img src="../icons/allegorical.svg " alt="Imagem alegorica de carnaval" srcset="" class="img_cover">
    </header>


    <div class="div_list">
      <div class="title_list">
        <h1 class="recommend_movie">recommend movie</h1>
        <div class="options_items">
          <button @click="this.saveFavorites" v-bind:disabled="this.list.length === 0" class="button_save_favorites">Save Favorites</button>
          <button @click="this.logout" class="button_logout_user button_save_favorites ">Logout</button>
        </div>
      </div>
      <div class="is_empty_list" v-if="this.list.length === 0">
        <h1 class="title_movie">Sorry we couldn't find any matches for movies from
        </h1>
        <mark v-if="this.$route.params.search" class="mark_search_items title_movie "> {{this.$route.params.search}}
        </mark>
      </div>
      <div v-else class="list">
        <div class="item" v-for="item in this.list">
          <div class="div_img">
            <img v-if="item['foto']" :src="item['foto']" alt="" srcset="" class="img_cover img_movie"/>
            <img v-else src="../icons/allegorical.svg" alt="" srcset="" class="img_cover img_movie"/>
          </div>
          <div class="div_title_movie">
            <h1 class="title_movie" v-html="item['nome']"></h1>
            <div v-if="this.favorites" @click="this.favoritesAdd(item.id)">
              <img v-if="favorites.includes(item.id)" src="../icons/favoritesLiked.svg" alt="favorite"
                   class="img_favorite"/>
              <img v-else src="../icons/favoritesNoLiked.svg" alt="no favorite" class="img_favorite"/>
            </div>
          </div>
          <span class="synopses_movie" v-html="item['sinopse']"></span>

        </div>


      </div>
    </div>
  </div>

</template>

<script src="../scripts/reuse/ItemsSearch.js"></script>
<style src="../styles/ItemsSearch.css"></style>