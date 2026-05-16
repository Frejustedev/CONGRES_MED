import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../wayfinder'
/**
* @see \App\Http\Controllers\Webhooks\PaymentWebhookController::kkiapay
 * @see app/Http/Controllers/Webhooks/PaymentWebhookController.php:17
 * @route '/webhooks/payments/kkiapay'
 */
export const kkiapay = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: kkiapay.url(options),
    method: 'post',
})

kkiapay.definition = {
    methods: ["post"],
    url: '/webhooks/payments/kkiapay',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Webhooks\PaymentWebhookController::kkiapay
 * @see app/Http/Controllers/Webhooks/PaymentWebhookController.php:17
 * @route '/webhooks/payments/kkiapay'
 */
kkiapay.url = (options?: RouteQueryOptions) => {
    return kkiapay.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Webhooks\PaymentWebhookController::kkiapay
 * @see app/Http/Controllers/Webhooks/PaymentWebhookController.php:17
 * @route '/webhooks/payments/kkiapay'
 */
kkiapay.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: kkiapay.url(options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\Webhooks\PaymentWebhookController::kkiapay
 * @see app/Http/Controllers/Webhooks/PaymentWebhookController.php:17
 * @route '/webhooks/payments/kkiapay'
 */
    const kkiapayForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: kkiapay.url(options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Webhooks\PaymentWebhookController::kkiapay
 * @see app/Http/Controllers/Webhooks/PaymentWebhookController.php:17
 * @route '/webhooks/payments/kkiapay'
 */
        kkiapayForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: kkiapay.url(options),
            method: 'post',
        })
    
    kkiapay.form = kkiapayForm
/**
* @see \App\Http\Controllers\Webhooks\PaymentWebhookController::stripe
 * @see app/Http/Controllers/Webhooks/PaymentWebhookController.php:25
 * @route '/webhooks/payments/stripe'
 */
export const stripe = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: stripe.url(options),
    method: 'post',
})

stripe.definition = {
    methods: ["post"],
    url: '/webhooks/payments/stripe',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Webhooks\PaymentWebhookController::stripe
 * @see app/Http/Controllers/Webhooks/PaymentWebhookController.php:25
 * @route '/webhooks/payments/stripe'
 */
stripe.url = (options?: RouteQueryOptions) => {
    return stripe.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Webhooks\PaymentWebhookController::stripe
 * @see app/Http/Controllers/Webhooks/PaymentWebhookController.php:25
 * @route '/webhooks/payments/stripe'
 */
stripe.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: stripe.url(options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\Webhooks\PaymentWebhookController::stripe
 * @see app/Http/Controllers/Webhooks/PaymentWebhookController.php:25
 * @route '/webhooks/payments/stripe'
 */
    const stripeForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: stripe.url(options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Webhooks\PaymentWebhookController::stripe
 * @see app/Http/Controllers/Webhooks/PaymentWebhookController.php:25
 * @route '/webhooks/payments/stripe'
 */
        stripeForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: stripe.url(options),
            method: 'post',
        })
    
    stripe.form = stripeForm
const webhooks = {
    kkiapay: Object.assign(kkiapay, kkiapay),
stripe: Object.assign(stripe, stripe),
}

export default webhooks