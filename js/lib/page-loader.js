import Loader from "./Loader";

export const pageLoader = () => {
    let loader = new Loader($("#mainLoader"));
    loader.hide();
}