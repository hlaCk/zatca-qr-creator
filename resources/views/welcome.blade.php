<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Create ZATCA QR by hlaCk</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
            integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
            crossorigin="anonymous"></script>
    <!-- Styles -->
    <style>
        /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */
        html {
            line-height: 1.15;
            -webkit-text-size-adjust: 100%
        }

        body {
            margin: 0
        }

        a {
            background-color: transparent
        }

        [hidden] {
            display: none
        }

        html {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica Neue, Arial, Noto Sans, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol, Noto Color Emoji;
            line-height: 1.5
        }

        *,
        :after,
        :before {
            box-sizing: border-box;
            border: 0 solid #e2e8f0
        }

        a {
            color: inherit;
            text-decoration: inherit
        }

        svg,
        video {
            display: block;
            vertical-align: middle
        }

        video {
            max-width: 100%;
            height: auto
        }

        .bg-white {
            --bg-opacity: 1;
            background-color: #fff;
            background-color: rgba(255, 255, 255, var(--bg-opacity))
        }

        .bg-gray-100 {
            --bg-opacity: 1;
            background-color: #f7fafc;
            background-color: rgba(247, 250, 252, var(--bg-opacity))
        }

        .border-gray-200 {
            --border-opacity: 1;
            border-color: #edf2f7;
            border-color: rgba(237, 242, 247, var(--border-opacity))
        }

        .border-t {
            border-top-width: 1px
        }

        .flex {
            display: flex
        }

        .grid {
            display: grid
        }

        .hidden {
            display: none
        }

        .items-center {
            align-items: center
        }

        .justify-center {
            justify-content: center
        }

        .font-semibold {
            font-weight: 600
        }

        .h-5 {
            height: 1.25rem
        }

        .h-8 {
            height: 2rem
        }

        .h-16 {
            height: 4rem
        }

        .text-sm {
            font-size: .875rem
        }

        .text-lg {
            font-size: 1.125rem
        }

        .leading-7 {
            line-height: 1.75rem
        }

        .mx-auto {
            margin-left: auto;
            margin-right: auto
        }

        .ml-1 {
            margin-left: .25rem
        }

        .mt-2 {
            margin-top: .5rem
        }

        .mr-2 {
            margin-right: .5rem
        }

        .ml-2 {
            margin-left: .5rem
        }

        .mt-4 {
            margin-top: 1rem
        }

        .ml-4 {
            margin-left: 1rem
        }

        .mt-8 {
            margin-top: 2rem
        }

        .ml-12 {
            margin-left: 3rem
        }

        .-mt-px {
            margin-top: -1px
        }

        .max-w-6xl {
            max-width: 72rem
        }

        .min-h-screen {
            min-height: 100vh
        }

        .overflow-hidden {
            overflow: hidden
        }

        .p-6 {
            padding: 1.5rem
        }

        .py-4 {
            padding-top: 1rem;
            padding-bottom: 1rem
        }

        .px-6 {
            padding-left: 1.5rem;
            padding-right: 1.5rem
        }

        .pt-8 {
            padding-top: 2rem
        }

        .fixed {
            position: fixed
        }

        .relative {
            position: relative
        }

        .top-0 {
            top: 0
        }

        .right-0 {
            right: 0
        }

        .shadow {
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .1), 0 1px 2px 0 rgba(0, 0, 0, .06)
        }

        .text-center {
            text-align: center
        }

        .text-gray-200 {
            --text-opacity: 1;
            color: #edf2f7;
            color: rgba(237, 242, 247, var(--text-opacity))
        }

        .text-gray-300 {
            --text-opacity: 1;
            color: #e2e8f0;
            color: rgba(226, 232, 240, var(--text-opacity))
        }

        .text-gray-400 {
            --text-opacity: 1;
            color: #cbd5e0;
            color: rgba(203, 213, 224, var(--text-opacity))
        }

        .text-gray-500 {
            --text-opacity: 1;
            color: #a0aec0;
            color: rgba(160, 174, 192, var(--text-opacity))
        }

        .text-gray-600 {
            --text-opacity: 1;
            color: #718096;
            color: rgba(113, 128, 150, var(--text-opacity))
        }

        .text-gray-700 {
            --text-opacity: 1;
            color: #4a5568;
            color: rgba(74, 85, 104, var(--text-opacity))
        }

        .text-gray-900 {
            --text-opacity: 1;
            color: #1a202c;
            color: rgba(26, 32, 44, var(--text-opacity))
        }

        .underline {
            text-decoration: underline
        }

        .antialiased {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale
        }

        .w-5 {
            width: 1.25rem
        }

        .w-8 {
            width: 2rem
        }

        .w-auto {
            width: auto
        }

        .grid-cols-1 {
            grid-template-columns: repeat(1, minmax(0, 1fr))
        }

        @media (min-width: 640px) {
            .sm\:rounded-lg {
                border-radius: .5rem
            }

            .sm\:block {
                display: block
            }

            .sm\:items-center {
                align-items: center
            }

            .sm\:justify-start {
                justify-content: flex-start
            }

            .sm\:justify-between {
                justify-content: space-between
            }

            .sm\:h-20 {
                height: 5rem
            }

            .sm\:ml-0 {
                margin-left: 0
            }

            .sm\:px-6 {
                padding-left: 1.5rem;
                padding-right: 1.5rem
            }

            .sm\:pt-0 {
                padding-top: 0
            }

            .sm\:text-left {
                text-align: left
            }

            .sm\:text-right {
                text-align: right
            }
        }

        @media (min-width: 768px) {
            .md\:border-t-0 {
                border-top-width: 0
            }

            .md\:border-l {
                border-left-width: 1px
            }

            .md\:grid-cols-2 {
                grid-template-columns: repeat(2, minmax(0, 1fr))
            }
        }

        @media (min-width: 1024px) {
            .lg\:px-8 {
                padding-left: 2rem;
                padding-right: 2rem
            }
        }

        @media (prefers-color-scheme: dark) {
            .dark\:bg-gray-800 {
                --bg-opacity: 1;
                background-color: #2d3748;
                background-color: rgba(45, 55, 72, var(--bg-opacity))
            }

            .dark\:bg-gray-900 {
                --bg-opacity: 1;
                background-color: #1a202c;
                background-color: rgba(26, 32, 44, var(--bg-opacity))
            }

            .dark\:border-gray-700 {
                --border-opacity: 1;
                border-color: #4a5568;
                border-color: rgba(74, 85, 104, var(--border-opacity))
            }

            .dark\:text-white {
                --text-opacity: 1;
                color: #fff;
                color: rgba(255, 255, 255, var(--text-opacity))
            }

            .dark\:text-gray-400 {
                --text-opacity: 1;
                color: #cbd5e0;
                color: rgba(203, 213, 224, var(--text-opacity))
            }

            .dark\:text-gray-500 {
                --tw-text-opacity: 1;
                color: #6b7280;
                color: rgba(107, 114, 128, var(--tw-text-opacity))
            }
        }
    </style>

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>
<body class="antialiased bg-gray-100 dark:bg-gray-900 justify-center"
      onload="fixTotal('{{$total??''}}' || 0); document.getElementById('vat_id').oninput(); let _e = @error('vat_id') document.getElementById('vat_id') @else document.getElementById('company') @enderror ; _e.focus(); _e.select();">

@if(isset($showForm))
    <div
        class="items-top justify-center relative sm:items-center w-75 m-auto">

        <div class="form-group text-center">
            <a href="{{$download}}" target="_blank" title="Download QR Image">
                <img src="{{$showForm}}" alt="ZATCA QRCode m-auto"/>
            </a>

            <div class="btn-group-vertical">
                <a href="{{$download}}" target="_blank" title="Download QR Image" class="btn btn-lg btn-success m-1">Download - تحميل</a>
                @if($hasData ?? '')
                    <br>
                    <button type="button" class="btn btn-lg btn-dark m-1" onclick="resetForm(event)">New - جديد</button>
                @endif
            </div>
        </div>

    </div>
@endif

<div
    class="relative flex items-top justify-center sm:items-center py-4 sm:pt-0">
    <form method="post" action="{{route('home', ['data'=>$hash ?? $data ?? ''])}}" class="w-75">

        @if(count($errors) > 0 )
            <div class="alert alert-danger alert-dismissible fade show w-100" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <ul class="p-0 m-0" style="list-style: none;">
                    @foreach($errors->all() as $error)
                        <li class="text-center">{{$error}}</li>
                    @endforeach
                </ul>
            </div>
            <br/>
        @endif

        @csrf

        <div class="form-group">
            <label for="company">Company</label>
            <input required type="text" class="form-control" name="company" id="company" aria-describedby="companyHelp"
                   placeholder="Enter Company" value="{{$company??''}}">
            <small id="companyHelp" class="form-text text-muted text-right">اسم الشركة</small>
        </div>
        <div class="form-group">
            <label for="vat_id">
                Vat Number
                |
                <span class="text-danger text-sm countChar">0</span>
                <span class="text-sm">Char</span>
            </label>
            <input required type="number" class="form-control @error('vat_id') alert-danger border-danger @enderror" name="vat_id" id="vat_id" aria-describedby="vat_idHelp"
                   placeholder="Enter Vat Number" value="{{$vat_id??''}}" oninput="countChars(this.value, document.querySelectorAll('.countChar'))">
            <small id="vat_idHelp" class="form-text text-muted text-right">
                الرقم الضريبي
                |
                <span class="text-danger text-sm countChar">0</span>
                <span class="text-sm">حرف</span>
            </small>
        </div>
        <div class="form-group">
            <label for="invoice_date">Invoice Date</label>
            <span class="text-secondary font-italic" style="font-size: xx-small;" title="{{$invoice_date??null}} {{$invoice_time??null}}">{{$invoice_date??null}} {{$invoice_time??null}}</span>
            <input
                required
                type="datetime-local"
                class="form-control"
                name="invoice_date"
                id="invoice_date"
                aria-describedby="invoice_dateHelp"
                placeholder="Enter Invoice Date"
                value="{{ parseInvoiceDateToInput($invoice_date ?? null, $invoice_time ?? null) }}"
            >
            <small id="invoice_dateHelp" class="form-text text-muted text-right">تاريخ الفاتورة</small>
        </div>
        <div class="form-group">
            <label for="total">Total Without Vat</label>
            <input
                required
                type="number"
                step="0.01"
                min="0.01"
                onfocus="this.focus(); this.select()"
                class="form-control"
                name="total"
                onchange="calcVat(this.value)"
                onkeyup="calcVat(this.value)"
                id="total"
                aria-describedby="totalHelp"
                placeholder="Enter Invoice Total Without Vat Amount"
                value="{{$total??0}}"
            >
            <small id="totalHelp" class="form-text text-muted text-right">اجمالي الفاتورة بدون الضريبة</small>
        </div>
        <div class="form-group">
            <label for="invoice_total_amount">Total Amount</label>
            <input required type="number" readonly class="form-control" name="invoice_total_amount" id="invoice_total_amount"
                   aria-describedby="invoice_total_amountHelp" placeholder="Invoice Total Amount"
                   value="{{$invoice_total_amount??0}}">
            <small id="invoice_total_amountHelp" class="form-text text-muted text-right">اجمالي الفاتورة</small>
        </div>
        <div class="form-group">
            <label for="vat_amount">Vat Amount</label>
            <input required type="number" readonly class="form-control" name="vat_amount" id="vat_amount"
                   aria-describedby="vat_amountHelp" placeholder="Vat Amount" value="{{$vat_amount??0}}">
            <small id="vat_amountHelp" class="form-text text-muted text-right">قيمة الضريبة</small>
        </div>

        <button type="submit" class="btn btn-primary btn-block btn-lg">Generate - إنشاء</button>
    </form>


</div>

<script>
    function fixTotal(n) {
        document.getElementById('total').value = Number(n);
    }

    function calcVat(n) {
        n = parseFloat(n);
        let t = (n / 100) * 15;

        document.getElementById('invoice_total_amount').value = parseFloat(n + t).toFixed(2);
        document.getElementById('vat_amount').value = parseFloat(t).toFixed(2);
    }

    function resetForm(event) {
        event.preventDefault();
        if (confirm("Are you sure?\nهل انت متاكد؟")) {
            location.href = '{{route('home')}}';
        }
    }

    function countChars(value, elms) {
        let len = value.length;
        Array.from(elms).forEach(x=> {
            x.innerText = len;
            x.classList.remove('text-muted', 'text-danger');
            x.classList.add(len != 15 && 'text-danger' || 'text-muted');
        });
    }
</script>
</body>
</html>
