// Allows, thanks to the position of the scrollbar, to change the position of the menu.
let menu = document.getElementById("menu");

if (menu) {
    window.addEventListener("scroll", function () {
        let currentScroll = document.body.scrollTop || document.documentElement.scrollTop;
        menu.className = (currentScroll >= menu.offsetHeight + 101) ? "menu flexCenter flexRow floatable" : "menu flexCenter flexRow";
    }, false);
}

// When we click on "logoMenu", we bring up the sub menu or disappear.
if (document.getElementById("logoMenu")) {
    display("logoMenu", "subMenu", "flex")
}

// When we click on "filter", we bring up the categories on filter or disappear.
if (document.getElementById("filterCategories")) {
    display("filterCategories","categories", "block");
}

// When we click on "Mon compte", we bring up the sub menu or disappear.
if (document.getElementById("buttonAccount")) {
    display("buttonAccount", "menuAccountMobile", "flex");
}

// When we click on "Loi RGPD", we bring up the information about the law or disappear.
if (document.getElementById("law")) {
    display("law", "infoLaw", "block");
}

// If the modal window has the error ID then it appears and clicking on the cross makes it disappear.
if (document.getElementById("error")) {
    document.getElementById("closeModal").style.display = "block";
    closeModal("error");
}

// If the modal window has the ID success then it appears and clicking on the cross makes it disappear.
if (document.getElementById("success")) {
    document.getElementById("closeModal").style.display = "block";
    closeModal("success");
}

/**
 * Removes the modal window by clicking on the cross.
 * @param idModal
 */
function closeModal (idModal) {
    document.getElementById("closeModal").addEventListener("click", function () {
        document.getElementById(idModal).style.display = "none";
    });
}

// Allows you to make what you want to appear or disappear
function display (idClick, id, display) {
    let nbClick = 0;
    document.getElementById(idClick).addEventListener("click", function () {
        if (nbClick === 0) {
            document.getElementById(id).style.display = display;
            nbClick++;
        }
        else {
            document.getElementById(id).style.display = "none";
            nbClick = 0;
        }
    });
}