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
    $.getJSON(
      universityData.root_url +
        "/wp-json/university/v1/search?term=" +
        this.searchField.val(),
      (results) => {
        this.resultsDiv.html(`
        <div class="row">
          <div class="one-third">
            <h2 class="search-overlay__section-title">General Information</h2>
            ${
              results.generalInfo.length
                ? '<ul class="link-list min-list">'
                : "<p>No general information matches search</p>"
            }
              ${results.generalInfo
                .map(
                  (post) =>
                    `<li><a href="${post.link}">${post.title}</a> ${
                      post.postType == "post" ? `by ${post.authorName}` : ""
                    }</li>`
                )
                .join("")}
              ${results.generalInfo.length ? "</ul>" : ""}
          </div>
          <div class="one-third">
            <h2 class="search-overlay__section-title">Programs</h2>
            ${
              results.programs.length
                ? '<ul class="link-list min-list">'
                : `<p>No Programs matches search. <a href='${universityData.root_url}/programs'>View All Programs</a></p>`
            }
              ${results.programs
                .map(
                  (post) => `<li><a href="${post.link}">${post.title}</a></li>`
                )
                .join("")}
              ${results.programs.length ? "</ul>" : ""}

            <h2 class="search-overlay__section-title">Professors</h2>
            ${
              results.professors.length
                ? '<ul class="professor-cards">'
                : `<p>No Professors matches search.</p>`
            }
              ${results.professors
                .map(
                  (post) =>
                    `
                    <li class="professor-card__list-item">
                      <a class="professor-card" href="${post.link}">
                      <img src="${post.image}" alt="" class="professor-card__image">
                      <span class="professor-card__name">${post.title}</span>
                      </a>
                    </li>      
                    `
                )
                .join("")}
              ${results.professors.length ? "</ul>" : ""}
            
          </div>
          <div class="one-third">
            <h2 class="search-overlay__section-title">Campuses</h2>
            ${
              results.campuses.length
                ? '<ul class="link-list min-list">'
                : "<p>No Campuses matches search. <a href='${universityData.root_url}/campuses'>View All Campuses</a></p>"
            }
              ${results.campuses
                .map(
                  (post) => `<li><a href="${post.link}">${post.title}</a></li>`
                )
                .join("")}
              ${results.campuses.length ? "</ul>" : ""}


            <h2 class="search-overlay__section-title">Events</h2>
            ${
              results.events.length
                ? ""
                : "<p>No events matches search. <a href='${universityData.root_url}/events'>View All Events</a></p>"
            }
              ${results.events
                .map(
                  (post) =>
                    `
                    <div class="event-summary">
                    <a class="event-summary__date t-center" href="${post.link}">
                      <span class="event-summary__month">${post.month}</span>
                      <span class="event-summary__day">${post.day}</span>
                    </a>
                    <div class="event-summary__content">
                      <h5 class="event-summary__title headline headline--tiny"><a href="${post.link}">${post.title}</a></h5>
                      <p>${post.description}<a href="${post.link}" class="nu gray">Learn more</a></p>
                    </div>
                  </div>
                    `
                )
                .join("")}
          </div>
          
        </div>
      `);
        this.isSpinnerVisable = false;
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
