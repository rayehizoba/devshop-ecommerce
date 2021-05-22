<div class="container py-10 space-y-10">
    <script src="https://js.stripe.com/v3/"></script>
    <script>
      // A reference to Stripe.js initialized with your real test publishable API key.
      const stripe = Stripe("pk_test_51Iu0IkLzGV7Que857BQdpXUBqQ9cM6XLN0vXk63cUy0f69X24CVxKirwrCpbMaqN3lscRdhtwsf2Mb7IbK7z1vL900shyYU0zn");

      // The items the customer wants to buy
      const purchase = @json($items);

      // Disable the button until we have Stripe set up on the page
      // document.getElementById("submit").disabled = true;
      fetch("/payment-intent", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(purchase)
      })
        .then(function(result) {
          return result.json();
        })
        .then(function(data) {
          var elements = stripe.elements();

          var style = {
            base: {
              color: "#32325d",
              fontFamily: 'Arial, sans-serif',
              fontSmoothing: "antialiased",
              fontSize: "16px",
              "::placeholder": {
                color: "#32325d"
              }
            },
            invalid: {
              fontFamily: 'Arial, sans-serif',
              color: "#fa755a",
              iconColor: "#fa755a"
            }
          };

          var card = elements.create("card", { style: style });
          // Stripe injects an iframe into the DOM
          card.mount("#card-element");

          card.on("change", function (event) {
            // Disable the Pay button if there are no card details in the Element
            document.querySelector("button").disabled = event.empty;
            document.querySelector("#card-error").textContent = event.error ? event.error.message : "";
          });

          var form = document.getElementById("payment-form");
          form.addEventListener("submit", function(event) {
            event.preventDefault();
            // Complete payment when the submit button is clicked
            payWithCard(stripe, card, data.clientSecret);
          });
        });

      // Calls stripe.confirmCardPayment
      // If the card requires authentication Stripe shows a pop-up modal to
      // prompt the user to enter authentication details without leaving your page.
      var payWithCard = function(stripe, card, clientSecret) {
        loading(true);
        stripe
          .confirmCardPayment(clientSecret, {
            payment_method: {
              card: card
            }
          })
          .then(function(result) {
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
      var orderComplete = function(paymentIntentId) {
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
      var showError = function(errorMsgText) {
        loading(false);
        var errorMsg = document.querySelector("#card-error");
        errorMsg.textContent = errorMsgText;
        setTimeout(function() {
          errorMsg.textContent = "";
        }, 4000);
      };

      // Show a spinner on payment submission
      var loading = function(isLoading) {
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

    </script>

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

    <div class="flex flex-col lg:flex-row space-y-10 lg:space-y-0 lg:space-x-16">
        <div class="w-full lg:w-3/5 space-y-5">
            <p class="font-medium text-2xl">
                Billing details
            </p>
            <div class="grid grid-cols-2 gap-5">
                <div>
                    <label for="firstname" class="text-sm font-medium">
                        First Name <span class="text-red-500">*</span>
                    </label>
                    <x-jet-input id="firstname" type="text" class="mt-1 block w-full"
                                 wire:model.defer="form.firstname"/>
                </div>
                <div>
                    <label for="lastname" class="text-sm font-medium">
                        Last Name <span class="text-red-500">*</span>
                    </label>
                    <x-jet-input id="lastname" type="text" class="mt-1 block w-full" wire:model.defer="form.lastname"/>
                </div>
            </div>

            <div>
                <label for="email" class="text-sm font-medium">
                    Email address <span class="text-red-500">*</span>
                </label>
                <x-jet-input id="email" type="email" class="mt-1 block w-full" wire:model.defer="form.email"/>
            </div>
        </div>
        <div class="w-full lg:w-2/5 border border-gray-300 rounded-lg shadow-lg p-5 pb-10 space-y-5">
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
                <div class="flex items-center justify-center uppercase text-gray-400 text-xs font-medium">



                    <form id="payment-form" class="w-full">
                        <div id="card-element"><!--Stripe.js injects the Card Element--></div>
                        <x-jet-button id="submit" class="justify-center w-full py-4">
                            <div class="spinner hidden" id="spinner"></div>
                            <span id="button-text">Place order</span>
                        </x-jet-button>
                        <p id="card-error" role="alert"></p>
                        <p class="result-message hidden">
                            Payment succeeded, see the result in your
                            <a href="" target="_blank">Stripe dashboard.</a> Refresh the page to pay again.
                        </p>
                    </form>




                </div>
{{--                <x-jet-button class="justify-center w-full py-4">--}}
{{--                    Place order--}}
{{--                </x-jet-button>--}}
            </div>
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

