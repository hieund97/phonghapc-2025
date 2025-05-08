<div class="form-group">
    <label>Cascader Demo</label>

    <div class="cascader">
        <div class="form-control">Form content</div>

        <div class="cascader-menu">
            <ul class="cascader-list">
                <li>Root #1</li>
                <li>Root #2</li>
                <li>Root #3</li>
            </ul>

            <ul class="cascader-list">
                <li>Child #1</li>
                <li>Child #2</li>
                <li>Child #3</li>
                <li>Child #4</li>
                <li>Child #5</li>
                <li>Child #6</li>
                <li>Child #7</li>
                <li>Child #8</li>
                <li>Child #9</li>
                <li>Child #10</li>
            </ul>

            <ul class="cascader-list">
                <li>Child #11</li>
                <li>Child #12</li>
                <li>Child #13</li>
                <li>Child #14</li>
            </ul>

            <ul class="cascader-list">
                <li>Child #15</li>
                <li>Child #16</li>
            </ul>
        </div>
    </div>
</div>

@push('styles')
    <style>
        .cascader {
            display: block;
            position: relative;
            width: 100%;
        }

        .cascader > .form-control {
            cursor: pointer;
            user-select: none;
        }

        .cascader-menu {
            position: absolute;
            z-index: 999;
            margin-top: 5px;
        }

        .cascader-list {
            background: #ffffff;
            display: inline-block;
            vertical-align: top;
            border: 1px solid #ced4da;
            margin: 0;
            padding: 0;
            min-width: 150px;
            list-style-type: none;
        }

        .cascader-list > li {
            height: 36px;
            line-height: 36px;
            cursor: pointer;
        }

        .cascader-list > li:hover {
            background: #0879FB;
            color: #ffffff;
        }
    </style>
@endpush

@push('scripts')
    <script>

    </script>
@endpush
