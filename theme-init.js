(() => {
    try {
        if (localStorage.getItem("ironinvest-theme") === "dark") {
            document.documentElement.dataset.theme = "dark";
        }
    } catch (erro) {
        document.documentElement.dataset.theme = "light";
    }
})();
