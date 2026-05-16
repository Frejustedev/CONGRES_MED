import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../wayfinder'
import eventE3138f from './event'
import branding3fced6 from './branding'
import modules08af44 from './modules'
import payment44796b from './payment'
import mail14724b from './mail'
/**
* @see \App\Http\Controllers\Admin\SettingsController::event
 * @see app/Http/Controllers/Admin/SettingsController.php:18
 * @route '/admin/settings/event'
 */
export const event = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: event.url(options),
    method: 'get',
})

event.definition = {
    methods: ["get","head"],
    url: '/admin/settings/event',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Admin\SettingsController::event
 * @see app/Http/Controllers/Admin/SettingsController.php:18
 * @route '/admin/settings/event'
 */
event.url = (options?: RouteQueryOptions) => {
    return event.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\SettingsController::event
 * @see app/Http/Controllers/Admin/SettingsController.php:18
 * @route '/admin/settings/event'
 */
event.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: event.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Admin\SettingsController::event
 * @see app/Http/Controllers/Admin/SettingsController.php:18
 * @route '/admin/settings/event'
 */
event.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: event.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Admin\SettingsController::event
 * @see app/Http/Controllers/Admin/SettingsController.php:18
 * @route '/admin/settings/event'
 */
    const eventForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: event.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Admin\SettingsController::event
 * @see app/Http/Controllers/Admin/SettingsController.php:18
 * @route '/admin/settings/event'
 */
        eventForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: event.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Admin\SettingsController::event
 * @see app/Http/Controllers/Admin/SettingsController.php:18
 * @route '/admin/settings/event'
 */
        eventForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: event.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    event.form = eventForm
/**
* @see \App\Http\Controllers\Admin\SettingsController::branding
 * @see app/Http/Controllers/Admin/SettingsController.php:66
 * @route '/admin/settings/branding'
 */
export const branding = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: branding.url(options),
    method: 'get',
})

branding.definition = {
    methods: ["get","head"],
    url: '/admin/settings/branding',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Admin\SettingsController::branding
 * @see app/Http/Controllers/Admin/SettingsController.php:66
 * @route '/admin/settings/branding'
 */
branding.url = (options?: RouteQueryOptions) => {
    return branding.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\SettingsController::branding
 * @see app/Http/Controllers/Admin/SettingsController.php:66
 * @route '/admin/settings/branding'
 */
branding.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: branding.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Admin\SettingsController::branding
 * @see app/Http/Controllers/Admin/SettingsController.php:66
 * @route '/admin/settings/branding'
 */
branding.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: branding.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Admin\SettingsController::branding
 * @see app/Http/Controllers/Admin/SettingsController.php:66
 * @route '/admin/settings/branding'
 */
    const brandingForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: branding.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Admin\SettingsController::branding
 * @see app/Http/Controllers/Admin/SettingsController.php:66
 * @route '/admin/settings/branding'
 */
        brandingForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: branding.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Admin\SettingsController::branding
 * @see app/Http/Controllers/Admin/SettingsController.php:66
 * @route '/admin/settings/branding'
 */
        brandingForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: branding.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    branding.form = brandingForm
/**
* @see \App\Http\Controllers\Admin\SettingsController::modules
 * @see app/Http/Controllers/Admin/SettingsController.php:131
 * @route '/admin/settings/modules'
 */
export const modules = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: modules.url(options),
    method: 'get',
})

modules.definition = {
    methods: ["get","head"],
    url: '/admin/settings/modules',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Admin\SettingsController::modules
 * @see app/Http/Controllers/Admin/SettingsController.php:131
 * @route '/admin/settings/modules'
 */
modules.url = (options?: RouteQueryOptions) => {
    return modules.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\SettingsController::modules
 * @see app/Http/Controllers/Admin/SettingsController.php:131
 * @route '/admin/settings/modules'
 */
modules.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: modules.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Admin\SettingsController::modules
 * @see app/Http/Controllers/Admin/SettingsController.php:131
 * @route '/admin/settings/modules'
 */
modules.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: modules.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Admin\SettingsController::modules
 * @see app/Http/Controllers/Admin/SettingsController.php:131
 * @route '/admin/settings/modules'
 */
    const modulesForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: modules.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Admin\SettingsController::modules
 * @see app/Http/Controllers/Admin/SettingsController.php:131
 * @route '/admin/settings/modules'
 */
        modulesForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: modules.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Admin\SettingsController::modules
 * @see app/Http/Controllers/Admin/SettingsController.php:131
 * @route '/admin/settings/modules'
 */
        modulesForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: modules.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    modules.form = modulesForm
/**
* @see \App\Http\Controllers\Admin\SettingsController::payment
 * @see app/Http/Controllers/Admin/SettingsController.php:155
 * @route '/admin/settings/payment'
 */
export const payment = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: payment.url(options),
    method: 'get',
})

payment.definition = {
    methods: ["get","head"],
    url: '/admin/settings/payment',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Admin\SettingsController::payment
 * @see app/Http/Controllers/Admin/SettingsController.php:155
 * @route '/admin/settings/payment'
 */
payment.url = (options?: RouteQueryOptions) => {
    return payment.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\SettingsController::payment
 * @see app/Http/Controllers/Admin/SettingsController.php:155
 * @route '/admin/settings/payment'
 */
payment.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: payment.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Admin\SettingsController::payment
 * @see app/Http/Controllers/Admin/SettingsController.php:155
 * @route '/admin/settings/payment'
 */
payment.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: payment.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Admin\SettingsController::payment
 * @see app/Http/Controllers/Admin/SettingsController.php:155
 * @route '/admin/settings/payment'
 */
    const paymentForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: payment.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Admin\SettingsController::payment
 * @see app/Http/Controllers/Admin/SettingsController.php:155
 * @route '/admin/settings/payment'
 */
        paymentForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: payment.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Admin\SettingsController::payment
 * @see app/Http/Controllers/Admin/SettingsController.php:155
 * @route '/admin/settings/payment'
 */
        paymentForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: payment.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    payment.form = paymentForm
/**
* @see \App\Http\Controllers\Admin\SettingsController::mail
 * @see app/Http/Controllers/Admin/SettingsController.php:192
 * @route '/admin/settings/mail'
 */
export const mail = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: mail.url(options),
    method: 'get',
})

mail.definition = {
    methods: ["get","head"],
    url: '/admin/settings/mail',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Admin\SettingsController::mail
 * @see app/Http/Controllers/Admin/SettingsController.php:192
 * @route '/admin/settings/mail'
 */
mail.url = (options?: RouteQueryOptions) => {
    return mail.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\SettingsController::mail
 * @see app/Http/Controllers/Admin/SettingsController.php:192
 * @route '/admin/settings/mail'
 */
mail.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: mail.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Admin\SettingsController::mail
 * @see app/Http/Controllers/Admin/SettingsController.php:192
 * @route '/admin/settings/mail'
 */
mail.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: mail.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Admin\SettingsController::mail
 * @see app/Http/Controllers/Admin/SettingsController.php:192
 * @route '/admin/settings/mail'
 */
    const mailForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: mail.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Admin\SettingsController::mail
 * @see app/Http/Controllers/Admin/SettingsController.php:192
 * @route '/admin/settings/mail'
 */
        mailForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: mail.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Admin\SettingsController::mail
 * @see app/Http/Controllers/Admin/SettingsController.php:192
 * @route '/admin/settings/mail'
 */
        mailForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: mail.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    mail.form = mailForm
const settings = {
    event: Object.assign(event, eventE3138f),
branding: Object.assign(branding, branding3fced6),
modules: Object.assign(modules, modules08af44),
payment: Object.assign(payment, payment44796b),
mail: Object.assign(mail, mail14724b),
}

export default settings