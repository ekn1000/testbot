export const activeIconMixin = {
    methods: {
        stopOrPauseIcon(state) {
            return state ? 'el-icon-video-pause' : 'el-icon-video-play';
        }
    }
}
