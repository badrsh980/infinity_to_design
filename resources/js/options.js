import axios from "axios";

var options = {};

axios
    .post("/api/get-options", {
        names: ["about_menu"],
    })
    .then((data) => {
        options = data;
    })
    .catch(function (error) {
        console.log(error);
    });

export default {
    options,
};
