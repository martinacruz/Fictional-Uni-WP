import $ from "jquery";

class Search {
  //1. describe and create/initiate our object
  constructor() {
    this.addSearchHTML();
    this.openButton = $(".js-search-trigger");
    this.closeButton = $(".search-overlay__close");
    this.searchOverlay = $(".search-overlay");
    this.searchField = $("#search-term");
    this.resultsDiv = $("#search-overlay__results");
    this.events();
    this.isOverlayOpen = false;
    this.isSpinnerVisable = false;
    this.typingTimer;
    this.previousValue;
  }

  //2. events
  events() {
    this.openButton.on("click", this.openOverlay.bind(this));
    this.closeButton.on("click", this.closeOverlay.bind(this));
    $(document).on("keydown", this.keypressDispatcher.bind(this));
    this.searchField.on("keydown", this.typingLogic.bind(this));
  }

  //3. methods (function, action...)
  typingLogic() {
    if (this.searchField.val() != this.previousValue) {
      clearTimeout(this.typingTimer);
      if (this.searchField.val()) {
        if (!this.isSpinnerVisable) {
          this.resultsDiv.html("<div class='spinner-loader'></div>");
          this.isSpinnerVisable = true;
        }
        this.typingTimer = setTimeout(this.getResults.bind(this), 750);
      } else {
        this.resultsDiv.html("");
        this.isSpinnerVisable = false;
      }
    }
    this.previousValue = this.searchField.val();
  }

  getResults() {
    $.when(
      $.getJSON(
        universityData.root_url +
          "/wp-json/wp/v2/posts?search=" +
          this.searchField.val()
      ),
      $.getJSON(
        universityData.root_url +
          "/wp-json/wp/v2/pages?search=" +
          this.searchField.val()
      )
    ).then(
      (posts, pages) => {
        let combinedResults = posts[0].concat(pages[0]);
        this.resultsDiv.html(`
    <h2 class="search-overlay__section-title">General Information</h2>
    ${
      combinedResults.length
        ? '<ul class="link-list min-list">'
        : "<p>No general information matches search</p>"
    }
      ${combinedResults
        .map(
          (post) =>
            `<li><a href="${post.link}">${post.title.rendered}</a> ${
              post.type == "post" ? `by ${post.authorName}` : ""
            }</li>`
        )
        .join("")}
      ${combinedResults.length ? "</ul>" : ""}
    
  `);
        this.isSpinnerVisable = false;
      },
      () => {
        this.resultsDiv.html("Unexpected Error, Please Try Again");
      }
    );
  }

  keypressDispatcher(e) {
    if (
      e.keyCode == 83 &&
      !this.isOverlayOpen &&
      !$("input", "textarea").is(":focus")
    ) {
      this.openOverlay();
      this.isOverlayOpen = true;
    }

    if (e.keyCode == 27 && this.isOverlayOpen) {
      this.closeOverlay();
      this.isOverlayOpen = false;
    }
  }

  openOverlay() {
    this.searchOverlay.addClass("search-overlay--active");
    $("body").addClass("body-no-scroll");
    this.searchField.val("");
    setTimeout(() => {
      this.searchField.focus();
    }, 301);
  }

  closeOverlay() {
    this.searchOverlay.removeClass("search-overlay--active");
    $("body").removeClass("body-no-scroll");
  }

  addSearchHTML() {
    $("body").append(`
    <div class="search-overlay">
      <div class="search-overlay__top">
        <div class="container">
          <i class="fa fa-search search-overlay__icon" aria-hidden="true"></i>
          <input type="text" class="search-term" autocomplete="off" placeholder="What are you looking for?" id="search-term">
          <i class="fa fa-window-close search-overlay__close" aria-hidden="true"></i>
      </div>
    </div>

    <div class="container">
      <div id="search-overlay__results"></div>
    </div>
  </div>
    `);
  }
}

export default Search;
