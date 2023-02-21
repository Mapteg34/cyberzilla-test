module.exports = {
    lintOnSave: false,

    runtimeCompiler: true,

    chainWebpack: config => {
        config
            .plugin("html")
            .tap(args => {
                args[0].title = "Панель администрирования filezilla";
                return args;
            });
    },
};
