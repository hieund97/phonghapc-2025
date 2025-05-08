import Vue from 'vue';
import {Cascader} from "ant-design-vue";

Vue.use(Cascader);

new Vue({
    template: '<a-cascader :options="options" placeholder="Please select" @change="onChange" />',
    data() {
        return {
            options: [
                {
                    value: 'zhejiang',
                    label: 'Zhejiang',
                    children: [
                        {
                            value: 'hangzhou',
                            label: 'Hangzhou',
                            children: [
                                {
                                    value: 'xihu',
                                    label: 'West Lake',
                                },
                            ],
                        },
                    ],
                },
                {
                    value: 'jiangsu',
                    label: 'Jiangsu',
                    children: [
                        {
                            value: 'nanjing',
                            label: 'Nanjing',
                            children: [
                                {
                                    value: 'zhonghuamen',
                                    label: 'Zhong Hua Men',
                                },
                            ],
                        },
                    ],
                },
            ],
        }
    },
    methods: {
        onChange(value) {
            console.log(value);
        },
    },
})
