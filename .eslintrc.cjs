/* eslint-env node */
require('@rushstack/eslint-patch/modern-module-resolution');

module.exports = {
    root: true,
    parserOptions: {
        ecmaVersion: 'latest',
    },
    extends: [
        'plugin:vue/vue3-recommended',
        'eslint:recommended',
        '@vue/eslint-config-typescript/recommended',
        '@vue/eslint-config-prettier',
    ],
    plugins: ['import', 'simple-import-sort'],
    rules: {
        'import/first': 'error',
        'import/newline-after-import': 'error',
        'import/no-duplicates': 'error',
        'simple-import-sort/imports': [
            'error',
            {
                groups: [
                    ['^\\u0000'],
                    ['^@?\\w.*\\u0000$', '^@?\\w'],
                    ['(?<=\\u0000)$', '^'],
                    ['^\\..*\\u0000$', '^\\.'],
                ],
            },
        ],
        'simple-import-sort/exports': 'error',
        'vue/attributes-order': ['error', { alphabetical: true }],
        'vue/multi-word-component-names': 'off',
        'vue/require-default-prop': 'off',
        'vue/require-explicit-emits': 'error',
        '@typescript-eslint/consistent-type-imports': [
            'error',
            { prefer: 'type-imports', disallowTypeAnnotations: false },
        ],
        '@typescript-eslint/no-explicit-any': 'off',
        '@typescript-eslint/no-unused-vars': ['warn', { ignoreRestSiblings: true }],
    },
};
