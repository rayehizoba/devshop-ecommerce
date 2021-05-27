<div>
    <script src="https://js.stripe.com/v3/"></script>
    <script>
      function checkoutPage() {
        // A reference to Stripe.js initialized with your real test publishable API key.
        const stripe = Stripe(@json(env('STRIPE_PUBLISHABLE_KEY')));

        const elements = stripe.elements();

        const style = {
          base: {
            color: "#32325d",
            fontFamily: 'Poppins, sans-serif',
            fontSmoothing: "antialiased",
            fontSize: "16px",
            "::placeholder": {
              color: "#32325d"
            }
          },
          invalid: {
            fontFamily: 'Poppins, sans-serif',
            color: "#fa755a",
            iconColor: "#fa755a"
          }
        };

        const cardElement = elements.create("card", {style: style});
        // Stripe injects an iframe into the DOM
        cardElement.mount("#card-element");

        cardElement.on("change", function (event) {
          // Disable the Pay button if there are no card details in the Element
          document.querySelector("button").disabled = event.empty;
          document.querySelector("#card-error").textContent = event.error ? event.error.message : "";
        });

        // Calls stripe.confirmCardPayment
        // If the card requires authentication Stripe shows a pop-up modal to
        // prompt the user to enter authentication details without leaving your page.
        const payWithCard = function (stripe, card) {
          loading(true);
          stripe
            .confirmCardPayment(@json($paymentIntent->client_secret), {
              payment_method: {
                card: card
              }
            })
            .then(function (result) {
              if (result.error) {
                // Show error to your customer
                showError(result.error.message);
              } else {
                // The payment succeeded!
                orderComplete(result.paymentIntent.id);
              }
            });
        };

        /* ------- UI helpers ------- */

        // Shows a success message when the payment is complete
        const orderComplete = function (paymentIntentId) {
          Livewire.emit('orderComplete', paymentIntentId);
          loading(false);
          document
            .querySelector(".result-message a")
            .setAttribute(
              "href",
              "https://dashboard.stripe.com/test/payments/" + paymentIntentId
            );
          document.querySelector(".result-message").classList.remove("hidden");
          document.querySelector("button").disabled = true;
        };

        // Show the customer the error from Stripe if their card fails to charge
        const showError = function (errorMsgText) {
          loading(false);
          const errorMsg = document.querySelector("#card-error");
          errorMsg.textContent = errorMsgText;
          setTimeout(function () {
            errorMsg.textContent = "";
          }, 4000);
        };

        // Show a spinner on payment submission
        const loading = function (isLoading) {
          if (isLoading) {
            // Disable the button and show a spinner
            document.querySelector("button").disabled = true;
            document.querySelector("#spinner").classList.remove("hidden");
            document.querySelector("#button-text").classList.add("hidden");
          } else {
            document.querySelector("button").disabled = false;
            document.querySelector("#spinner").classList.add("hidden");
            document.querySelector("#button-text").classList.remove("hidden");
          }
        };

        return {
          async submitPayment() {
            if (cardElement) {
              const validated = await this.$wire.validateForm();
              if (validated) {
                payWithCard(stripe, cardElement);
              } else {
                // show first input error
                const refInputErrors = document.querySelectorAll('[ref-input-error]');
                if (refInputErrors.length) {
                  refInputErrors[0].scrollIntoViewIfNeeded();
                }
              }
            }
          },
        }
      }
    </script>

    <div x-data="checkoutPage()" class="container py-10 space-y-10">
        <div class="flex items-center">
            <figure class="text-4xl md:text-5xl leading-tight md:leading-snug">
                🖥️📱
            </figure>
            <div>
                <h1 class="font-bold text-2xl md:text-3xl self-start">
                    devshop
                </h1>
                <ul class="flex items-center text-xs md:text-sm text-gray-500 space-x-1">
                    <li>
                        <a href="{{ route('home.page') }}" class="text-blue-500 transition hover:text-gray-500">
                            Home
                        </a>
                    </li>
                    <li>
                        >
                    </li>
                    <li>
                        <a href="{{ route('cart.page') }}" class="text-blue-500 transition hover:text-gray-500">
                            Cart
                        </a>
                    </li>
                    <li>
                        >
                    </li>
                    <li>
                        Checkout
                    </li>
                </ul>
            </div>
        </div>

        <div class="flex flex-col space-y-10 md:space-y-0 md:flex-row md:space-x-10 lg:space-x-16 md:items-start">
            <div class="w-full lg:w-7/12 space-y-5">
                <p class="font-medium text-2xl">
                    Billing details
                </p>

                <div>
                    <label for="name" class="text-sm font-medium">
                        Name <span class="text-red-500">*</span>
                    </label>
                    <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="name"/>
                    <x-jet-input-error ref-input-error for="name" class="mt-2" />
                </div>

                <div>
                    <label for="email" class="text-sm font-medium">
                        Email address <span class="text-red-500">*</span>
                    </label>
                    <x-jet-input id="email" type="email" class="mt-1 block w-full" wire:model.defer="email"/>
                    <x-jet-input-error ref-input-error for="email" class="mt-2" />
                </div>

                <div>
                    <label for="subscribe" class="flex items-center">
                        <x-jet-checkbox id="subscribe" wire:model.defer="subscribe" />
                        <span class="ml-2 text-sm text-gray-600">{{ __('Subscribe for Sales & New Templates') }}</span>
                    </label>
                </div>

                <div>
                    <label for="create_account" class="flex items-center">
                        <x-jet-checkbox id="create_account" name="create_account" />
                        <span class="ml-2 text-sm text-gray-600">{{ __('Create Account') }}</span>
                    </label>
                </div>
            </div>
            <div class="w-full lg:w-5/12 border border-gray-300 rounded-lg shadow-lg p-5 space-y-5">
                <ul class="text-sm divide-y space-y-3">
                    @foreach($items as $item)
                        <li class="flex justify-between items-center space-x-10 pt-3">
                            <div class="flex-1 space-y-1">
                                <div class="text-sm flex space-x-1">
                                    <p>{{ $item->name }}</p>
                                    <i class="mdi mdi-close"></i>
                                    <strong>{{ $item->quantity }}</strong>
                                </div>
                                <p class="text-gray-500 text-xs">
                                    License Type: {{ $item->attributes->license_type }}
                                </p>
                            </div>
                            <p>${{ $item->price }}</p>
                        </li>
                    @endforeach
                    <li class="flex justify-between items-center pt-3">
                        <p>Subtotal</p>
                        <p>${{ $subtotal }}</p>
                    </li>
                    <li class="flex justify-between items-center pt-3">
                        <p>Total</p>
                        <p>${{ $total }}</p>
                    </li>
                </ul>

                <div class="rounded-lg bg-gray-100 p-3">
                    <form class="w-full" wire:ignore>
                        <div class="h-10 px-3 flex items-center border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 rounded-md shadow-sm bg-white mb-3">
                            <div class="flex-1 text-sm text-gray-500" id="card-element">
                                <!--Stripe.js injects the Card Element-->
                                Please wait. Loading Stripe Payment...
                            </div>
                        </div>
                        <p id="card-error" role="alert" class="mb-3 text-sm text-red-500"></p>
                        <p class="result-message hidden text-sm mb-3">
                            Payment succeeded, see the result in your
                            <a href="" target="_blank">Stripe dashboard.</a> Refresh the page to pay again.
                        </p>
                        <x-jet-button type="button" x-on:click="submitPayment" class="justify-center w-full py-4">
                            <div class="spinner hidden" id="spinner">Placing order...</div>
                            <span id="button-text">Place order</span>
                        </x-jet-button>
                    </form>
                </div>

                @if(App::environment('local'))
                    <x-test-payment-cards />
                @endif

                <ul class="text-gray-500 text-xs space-y-2">
                    <li class="flex space-x-1">
                        <span>✅</span>
                        <p>
                            100% Satisfaction Guarantee
                        </p>
                    </li>
                    <li class="flex space-x-1">
                        <span>✅</span>
                        <p>
                            6 months technical support
                        </p>
                    </li>
                    <li class="flex space-x-1">
                        <span>✅</span>
                        <p>
                            30-day money-back guarantee
                        </p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

