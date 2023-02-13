import $ from 'jquery'
class Search {
  constructor () {
    this.addSearchHTML()
    this.openButton = $('.js-search-trigger')
    this.closeButton = $('.search-overlay__close')
    this.searchOverlay = $('.search-overlay')
    this.searchBox = $('#search-term')
    this.resultDiv = $('#search-overlay__results')
    this.typingTime
    this.previousvalue
    this.isOverlayOpen = false
    this.isSpinnerVisible = false
    this.events()
  }
  events () {
    this.openButton.on('click', this.openOverlay.bind(this))
    this.closeButton.on('click', this.closeOverlay.bind(this))
    $(document).on('keydown', this.keyPressDispatcher.bind(this))
    this.searchBox.on('keyup', this.typingLogic.bind(this))
  }
  typingLogic () {
    if (this.searchBox.val() != this.previousvalue) {
      clearTimeout(this.typingTime)
      if (this.searchBox.val()) {
        if (!this.isSpinnerVisible) {
          this.resultDiv.html('<div class="spinner-loader"></div>')
          this.isSpinnerVisible = true
        }
        this.typingTime = setTimeout(this.getResults.bind(this), 1 * 1000)
      } else {
        this.resultDiv.html('')
        this.isSpinnerVisible = false
      }
    }
    this.previousvalue = this.searchBox.val()
  }
  getResults () {
    $.getJSON(
      universityData.root_url +
        '/wp-json/university/v1/search?term=' +
        this.searchBox.val(),
      results => {
        this.resultDiv.html(`
        <div class="row">
          <div class="one-third">
          <h2 class="search-overlay__section-title">General Information</h2>
          ${
            results.general_info.length
              ? `<ul class="link-list min-list">`
              : `<p>No General Information Available</p>`
          }
    ${results.general_info
      .map(
        item =>
          `<li><a href="${item.link}">${item.title}</a>${
            item.post_type == 'post' ? ` by ${item.author_name}` : ``
          }</li>`
      )
      .join('')}
      ${results.general_info.length ? `</ul>` : ``}
          </div>
          <div class="one-third">
          <h2 class="search-overlay__section-title">Programs</h2>
          ${
            results.programs.length
              ? `<ul class="link-list min-list">`
              : `<p>No Programs Available</p>`
          }
    ${results.programs
      .map(item => `<li><a href="${item.link}">${item.title}</a></li>`)
      .join('')}
      ${results.programs.length ? `</ul>` : ``}
          <h2 class="search-overlay__section-title">Professors</h2>
          ${
            results.professors.length
              ? `<ul class="professors-card">`
              : `<p>No Professors Available</p>`
          }
    ${results.professors
      .map(
        item => `
      <li class="professor-card__list-item">
                        <a class="professor-card" href="${item.link}">
                            <img class="professor-card__image" src="${item.image_url}" alt="">
                            <span class="professor-card__name">${item.title}</span>

                        </a>
                    </li>
      `
      )
      .join('')}
      ${results.professors.length ? `</ul>` : ``}
          </div>
          <div class="one-third">
          <h2 class="search-overlay__section-title">Campuses</h2>
          ${
            results.campuses.length
              ? `<ul class="link-list min-list">`
              : `<p>No Campuses Available</p>`
          }
    ${results.campuses
      .map(item => `<li><a href="${item.link}">${item.title}</a></li>`)
      .join('')}
      ${results.events.length ? `</ul>` : ``}
          <h2 class="search-overlay__section-title">Events</h2>
          ${
            results.events.length
              ? `<ul class="link-list min-list">`
              : `<p>No Events Available</p>`
          }
    ${results.events
      .map(item => `<li><a href="${item.link}">${item.title}</a></li>`)
      .join('')}
      ${results.events.length ? `</ul>` : ``}
          </div>
        </div>
        `)
      }
    )
    this.isSpinnerVisible = false
    //   $.when(
    //     $.getJSON(
    //       universityData.root_url +
    //         '/wp-json/wp/v2/pages?search=' +
    //         this.searchBox.val()
    //     ),
    //     $.getJSON(
    //       universityData.root_url +
    //         '/wp-json/wp/v2/posts?search=' +
    //         this.searchBox.val()
    //     )
    //   ).then(
    //     (pages, posts) => {
    //       var combinedResult = posts[0].concat(pages[0])
    //       this.resultDiv.html(`
    // <h2 class="search-overlay__section-title">General Information</h2>
    // ${
    //   posts.length
    //     ? `<ul class="link-list min-list">`
    //     : `<p>No General Information Available</p>`
    // }
    // ${combinedResult
    //   .map(
    //     result =>
    //       `<li><a href="${result.link}">${result.title.rendered}</a>${
    //         result.type == 'post' ? ` by ${result.author_name}` : ``
    //       }</li>`
    //   )
    //   .join('')}
    //   ${combinedResult.length ? `</ul>` : ``}
    // `)
    //       this.isSpinnerVisible = false
    //     },
    //     () => {
    //       this.resultDiv.html(`<p>Something went wrong try again later.</p>`)
    //     }
    //   )
  }
  keyPressDispatcher (e) {
    if (
      e.keyCode == 83 &&
      !this.isOverlayOpen &&
      !$('input,textarea').is(':focus')
    ) {
      this.openOverlay()
    } else if (e.keyCode == 27 && this.isOverlayOpen) {
      this.closeOverlay()
    }
  }
  openOverlay () {
    this.searchOverlay.addClass('search-overlay--active')
    this.searchBox.val('')
    setTimeout(() => this.searchBox.focus(), 301)
    $('body').addClass('body-no-scroll')
    this.isOverlayOpen = true
    return false
  }
  closeOverlay () {
    this.searchOverlay.removeClass('search-overlay--active')
    $('body').removeClass('body-no-scroll')
    this.isOverlayOpen = false
  }
  addSearchHTML () {
    $('body').append(`
    <div class="search-overlay">
    <div class="search-overlay__top">
        <div class="container">
            <i class="fa fa-search search-overlay__icon" aria-hidden="true"></i>
            <input type="text" class="search-term" placeholder="What are you looking for?" id="search-term">
            <i class="fa fa-window-close search-overlay__close" aria-hidden="true"></i>
        </div>
    </div>
    <div class="container">
        <div id="search-overlay__results">

        </div>
    </div>
</div>
    `)
  }
}
export default Search
