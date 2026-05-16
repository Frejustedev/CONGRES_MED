import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../../wayfinder'
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
* @see \App\Http\Controllers\Admin\SettingsController::updateEvent
 * @see app/Http/Controllers/Admin/SettingsController.php:25
 * @route '/admin/settings/event'
 */
export const updateEvent = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: updateEvent.url(options),
    method: 'put',
})

updateEvent.definition = {
    methods: ["put"],
    url: '/admin/settings/event',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\Admin\SettingsController::updateEvent
 * @see app/Http/Controllers/Admin/SettingsController.php:25
 * @route '/admin/settings/event'
 */
updateEvent.url = (options?: RouteQueryOptions) => {
    return updateEvent.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\SettingsController::updateEvent
 * @see app/Http/Controllers/Admin/SettingsController.php:25
 * @route '/admin/settings/event'
 */
updateEvent.put = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: updateEvent.url(options),
    method: 'put',
})

    /**
* @see \App\Http\Controllers\Admin\SettingsController::updateEvent
 * @see app/Http/Controllers/Admin/SettingsController.php:25
 * @route '/admin/settings/event'
 */
    const updateEventForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: updateEvent.url({
                    [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                        _method: 'PUT',
                        ...(options?.query ?? options?.mergeQuery ?? {}),
                    }
                }),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Admin\SettingsController::updateEvent
 * @see app/Http/Controllers/Admin/SettingsController.php:25
 * @route '/admin/settings/event'
 */
        updateEventForm.put = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: updateEvent.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'PUT',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'post',
        })
    
    updateEvent.form = updateEventForm
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
* @see \App\Http\Controllers\Admin\SettingsController::updateBranding
 * @see app/Http/Controllers/Admin/SettingsController.php:98
 * @route '/admin/settings/branding'
 */
export const updateBranding = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: updateBranding.url(options),
    method: 'put',
})

updateBranding.definition = {
    methods: ["put"],
    url: '/admin/settings/branding',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\Admin\SettingsController::updateBranding
 * @see app/Http/Controllers/Admin/SettingsController.php:98
 * @route '/admin/settings/branding'
 */
updateBranding.url = (options?: RouteQueryOptions) => {
    return updateBranding.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\SettingsController::updateBranding
 * @see app/Http/Controllers/Admin/SettingsController.php:98
 * @route '/admin/settings/branding'
 */
updateBranding.put = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: updateBranding.url(options),
    method: 'put',
})

    /**
* @see \App\Http\Controllers\Admin\SettingsController::updateBranding
 * @see app/Http/Controllers/Admin/SettingsController.php:98
 * @route '/admin/settings/branding'
 */
    const updateBrandingForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: updateBranding.url({
                    [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                        _method: 'PUT',
                        ...(options?.query ?? options?.mergeQuery ?? {}),
                    }
                }),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Admin\SettingsController::updateBranding
 * @see app/Http/Controllers/Admin/SettingsController.php:98
 * @route '/admin/settings/branding'
 */
        updateBrandingForm.put = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: updateBranding.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'PUT',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'post',
        })
    
    updateBranding.form = updateBrandingForm
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
* @see \App\Http\Controllers\Admin\SettingsController::updateModules
 * @see app/Http/Controllers/Admin/SettingsController.php:138
 * @route '/admin/settings/modules'
 */
export const updateModules = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: updateModules.url(options),
    method: 'put',
})

updateModules.definition = {
    methods: ["put"],
    url: '/admin/settings/modules',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\Admin\SettingsController::updateModules
 * @see app/Http/Controllers/Admin/SettingsController.php:138
 * @route '/admin/settings/modules'
 */
updateModules.url = (options?: RouteQueryOptions) => {
    return updateModules.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\SettingsController::updateModules
 * @see app/Http/Controllers/Admin/SettingsController.php:138
 * @route '/admin/settings/modules'
 */
updateModules.put = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: updateModules.url(options),
    method: 'put',
})

    /**
* @see \App\Http\Controllers\Admin\SettingsController::updateModules
 * @see app/Http/Controllers/Admin/SettingsController.php:138
 * @route '/admin/settings/modules'
 */
    const updateModulesForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: updateModules.url({
                    [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                        _method: 'PUT',
                        ...(options?.query ?? options?.mergeQuery ?? {}),
                    }
                }),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Admin\SettingsController::updateModules
 * @see app/Http/Controllers/Admin/SettingsController.php:138
 * @route '/admin/settings/modules'
 */
        updateModulesForm.put = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: updateModules.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'PUT',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'post',
        })
    
    updateModules.form = updateModulesForm
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
* @see \App\Http\Controllers\Admin\SettingsController::updatePayment
 * @see app/Http/Controllers/Admin/SettingsController.php:162
 * @route '/admin/settings/payment'
 */
export const updatePayment = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: updatePayment.url(options),
    method: 'put',
})

updatePayment.definition = {
    methods: ["put"],
    url: '/admin/settings/payment',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\Admin\SettingsController::updatePayment
 * @see app/Http/Controllers/Admin/SettingsController.php:162
 * @route '/admin/settings/payment'
 */
updatePayment.url = (options?: RouteQueryOptions) => {
    return updatePayment.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\SettingsController::updatePayment
 * @see app/Http/Controllers/Admin/SettingsController.php:162
 * @route '/admin/settings/payment'
 */
updatePayment.put = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: updatePayment.url(options),
    method: 'put',
})

    /**
* @see \App\Http\Controllers\Admin\SettingsController::updatePayment
 * @see app/Http/Controllers/Admin/SettingsController.php:162
 * @route '/admin/settings/payment'
 */
    const updatePaymentForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: updatePayment.url({
                    [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                        _method: 'PUT',
                        ...(options?.query ?? options?.mergeQuery ?? {}),
                    }
                }),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Admin\SettingsController::updatePayment
 * @see app/Http/Controllers/Admin/SettingsController.php:162
 * @route '/admin/settings/payment'
 */
        updatePaymentForm.put = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: updatePayment.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'PUT',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'post',
        })
    
    updatePayment.form = updatePaymentForm
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
/**
* @see \App\Http\Controllers\Admin\SettingsController::updateMail
 * @see app/Http/Controllers/Admin/SettingsController.php:199
 * @route '/admin/settings/mail'
 */
export const updateMail = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: updateMail.url(options),
    method: 'put',
})

updateMail.definition = {
    methods: ["put"],
    url: '/admin/settings/mail',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\Admin\SettingsController::updateMail
 * @see app/Http/Controllers/Admin/SettingsController.php:199
 * @route '/admin/settings/mail'
 */
updateMail.url = (options?: RouteQueryOptions) => {
    return updateMail.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\SettingsController::updateMail
 * @see app/Http/Controllers/Admin/SettingsController.php:199
 * @route '/admin/settings/mail'
 */
updateMail.put = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: updateMail.url(options),
    method: 'put',
})

    /**
* @see \App\Http\Controllers\Admin\SettingsController::updateMail
 * @see app/Http/Controllers/Admin/SettingsController.php:199
 * @route '/admin/settings/mail'
 */
    const updateMailForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: updateMail.url({
                    [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                        _method: 'PUT',
                        ...(options?.query ?? options?.mergeQuery ?? {}),
                    }
                }),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Admin\SettingsController::updateMail
 * @see app/Http/Controllers/Admin/SettingsController.php:199
 * @route '/admin/settings/mail'
 */
        updateMailForm.put = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: updateMail.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'PUT',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'post',
        })
    
    updateMail.form = updateMailForm
/**
* @see \App\Http\Controllers\Admin\SettingsController::applyPreset
 * @see app/Http/Controllers/Admin/SettingsController.php:74
 * @route '/admin/settings/branding/apply-preset'
 */
export const applyPreset = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: applyPreset.url(options),
    method: 'post',
})

applyPreset.definition = {
    methods: ["post"],
    url: '/admin/settings/branding/apply-preset',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Admin\SettingsController::applyPreset
 * @see app/Http/Controllers/Admin/SettingsController.php:74
 * @route '/admin/settings/branding/apply-preset'
 */
applyPreset.url = (options?: RouteQueryOptions) => {
    return applyPreset.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\SettingsController::applyPreset
 * @see app/Http/Controllers/Admin/SettingsController.php:74
 * @route '/admin/settings/branding/apply-preset'
 */
applyPreset.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: applyPreset.url(options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\Admin\SettingsController::applyPreset
 * @see app/Http/Controllers/Admin/SettingsController.php:74
 * @route '/admin/settings/branding/apply-preset'
 */
    const applyPresetForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: applyPreset.url(options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Admin\SettingsController::applyPreset
 * @see app/Http/Controllers/Admin/SettingsController.php:74
 * @route '/admin/settings/branding/apply-preset'
 */
        applyPresetForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: applyPreset.url(options),
            method: 'post',
        })
    
    applyPreset.form = applyPresetForm
const SettingsController = { event, updateEvent, branding, updateBranding, modules, updateModules, payment, updatePayment, mail, updateMail, applyPreset }

export default SettingsController