(() => {
    const lerCookie = (nome) => {
        const item = document.cookie
            .split("; ")
            .find((cookie) => cookie.startsWith(`${nome}=`));

        return item ? decodeURIComponent(item.split("=").slice(1).join("=")) : "";
    };

    try {
        const tema = lerCookie("ironinvest_theme") || localStorage.getItem("ironinvest-theme");
        if (tema === "dark") {
            document.documentElement.dataset.theme = "dark";
        }
    } catch (erro) {
        document.documentElement.dataset.theme = "light";
    }
})();
