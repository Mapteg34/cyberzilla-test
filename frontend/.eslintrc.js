module.exports = {
    root: true,
    env: {
        node: true,
        es6: true,
        browser: true
    },
    parser: "vue-eslint-parser",
    extends: [
        "plugin:vue/base",
        "plugin:vue/essential",
        "plugin:vue/strongly-recommended",
        "plugin:vue/recommended",
        "eslint:recommended",
    ],
    parserOptions: {
        parser: "babel-eslint",
        ecmaVersion: 2020,
        sourceType: "module"
    },
    rules: {
        "no-console": process.env.NODE_ENV === "production" ? "warn" : "off",
        "no-debugger": process.env.NODE_ENV === "production" ? "warn" : "off",
        "indent": ["error", 4, {
            "SwitchCase": 1
        }],
        "vue/html-indent": ["error", 4],
        "quotes": [2, "double"],
        "comma-dangle": ["error", "only-multiline"],
        "no-fallthrough": "off",
    }
}
