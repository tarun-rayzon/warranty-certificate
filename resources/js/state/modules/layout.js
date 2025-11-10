

const savedLayout = JSON.parse(localStorage.getItem("resetValue")) || {};

const updateLocalStorage = () => {
    localStorage.setItem("resetValue", JSON.stringify(state));
}

const state = {
    layoutType: savedLayout.layoutType ?? 'horizontal',
    layoutWidth: savedLayout.layoutWidth ?? 'fluid',
    sidebarSize: savedLayout.sidebarSize ?? 'lg',
    topbar: savedLayout.topbar ?? 'light',
    mode: savedLayout.mode ?? 'light',
    position: savedLayout.position ?? 'fixed',
    sidebarView: savedLayout.sidebarView ?? 'default',
    sidebarColor: savedLayout.sidebarColor ?? 'dark',
    sidebarImage: savedLayout.sidebarImage ?? 'none',
    preloader: savedLayout.preloader ?? 'disable',
    visibility: savedLayout.visibility ?? 'show'
};

const mutations = {
    CHANGE_LAYOUT(state, layoutType) {
        state.layoutType = layoutType;
    },
    CHANGE_LAYOUT_WIDTH(state, layoutWidth) {
        state.layoutWidth = layoutWidth;
        updateLocalStorage();
    },
    CHANGE_SIDEBAR_TYPE(state, sidebarSize) {
        state.sidebarSize = sidebarSize;
        updateLocalStorage();
    },
    CHANGE_TOPBAR(state, topbar) {
        state.topbar = topbar;
        updateLocalStorage();
    },
    CHANGE_MODE(state, mode) {
        state.mode = mode;
        updateLocalStorage();
    },
    CHANGE_POSITION(state, position) {
        state.position = position;
        updateLocalStorage();
    },
    CHANGE_SIDEBAR_VIEW(state, sidebarView) {
        state.sidebarView = sidebarView;
        updateLocalStorage();
    },
    CHANGE_SIDEBAR_COLOR(state, sidebarColor) {
        state.sidebarColor = sidebarColor;
        updateLocalStorage();
    },
    CHANGE_SIDEBAR_IMAGE(state, sidebarImage) {
        state.sidebarImage = sidebarImage;
        updateLocalStorage();
    },
    CHANGE_PRELOADER(state, preloader) {
        state.preloader = preloader;
        updateLocalStorage();
    },
    CHANGE_VISIBILITY(state, visibility) {
        state.visibility = visibility;
        updateLocalStorage();
    }
};

const actions = {
    changeLayoutType({ commit }, { layoutType }) {
        commit('CHANGE_LAYOUT', layoutType);
        document.body.removeAttribute("style");
    },

    changeLayoutWidth({ commit }, { layoutWidth }) {
        commit('CHANGE_LAYOUT_WIDTH', layoutWidth);
    },

    changeSidebarSize({ commit }, { sidebarSize }) {
        commit('CHANGE_SIDEBAR_TYPE', sidebarSize);
    },

    changeTopbar({ commit }, { topbar }) {
        commit('CHANGE_TOPBAR', topbar);
    },

    changeMode({ commit }, { mode }) {
        commit('CHANGE_MODE', mode);
    },

    changePosition({ commit }, { position }) {
        commit('CHANGE_POSITION', position);
    },

    changeSidebarView({ commit }, { sidebarView }) {
        commit('CHANGE_SIDEBAR_VIEW', sidebarView);
    },

    changeSidebarColor({ commit }, { sidebarColor }) {
        commit('CHANGE_SIDEBAR_COLOR', sidebarColor);
    },

    changeSidebarImage({ commit }, { sidebarImage }) {
        commit('CHANGE_SIDEBAR_IMAGE', sidebarImage);
    },

    changePreloader({ commit }, { preloader }) {
        commit('CHANGE_PRELOADER', preloader);
    },

    changeVisibility({ commit }, { visibility }) {
        commit('CHANGE_VISIBILITY', visibility);
    }
};

export default {
    namespaced: true,
    state,
    mutations,
    actions,
};
