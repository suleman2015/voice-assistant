@php
    $activeGateways = \Modules\Payment\Models\PaymentGateway::enabled()->get();
@endphp

<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<!-- Payment Method Modal -->
<div class="modal fade shade" id="paymentMethodModal" tabindex="-1" aria-labelledby="paymentMethodModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content overflow-hidden border-0 rounded-4 shadow">

            <!-- Modal Header -->
            <div class="modal-header bg-primary text-white py-4 px-4">
                <h5 class="modal-title fw-bold w-100 text-center" id="paymentMethodModalLabel">
                    {{ __('Choose Payment Method') }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="{{ __('Close') }}"></button>
            </div>

            <div class="modal-body text-center">
                @foreach ($activeGateways as $gateway)
                    <button type="button" onclick="submitWithMethod('{{ $gateway->name }}')"
                        class="btn btn-lg px-4 py-3 rounded-2 m-2 payment-method-btn-hover d-inline-flex align-items-center">
                        <i class="{{ $gateway->icon }} fs-2 me-2"></i>
                        {{ $gateway->label ?? ucfirst($gateway->name) }}
                    </button>
                @endforeach
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer border-top border-dark px-4">
                <button type="button" class="btn btn-primary rounded-2 px-4" data-bs-dismiss="modal">
                    {{ __('Cancel') }}
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .payment-method-btn-hover,
    .payment-method-btn-hover {
        background-position: 100%;
        color: var(--bs-primary) !important;
        background-color: transparent;
        background-size: 300%;
        border-color: var(--bs-primary);
    }

    .payment-method-btn-hover:hover,
    .payment-method-btn-hover:hover {
        color: #fff;
        background-image: linear-gradient(30deg, rgba(75, 166, 239, 0.201) 50%, transparent 50%);
        background-repeat: no-repeat;
        background-position: 0%;
        transition: background 300ms ease-in-out, color 300ms ease-in-out;
        backdrop-filter: blur(100px);
    }
</style>
