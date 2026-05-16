import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\Admin\RegistrationManagementController::index
 * @see app/Http/Controllers/Admin/RegistrationManagementController.php:16
 * @route '/admin/registrations'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/admin/registrations',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Admin\RegistrationManagementController::index
 * @see app/Http/Controllers/Admin/RegistrationManagementController.php:16
 * @route '/admin/registrations'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\RegistrationManagementController::index
 * @see app/Http/Controllers/Admin/RegistrationManagementController.php:16
 * @route '/admin/registrations'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Admin\RegistrationManagementController::index
 * @see app/Http/Controllers/Admin/RegistrationManagementController.php:16
 * @route '/admin/registrations'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Admin\RegistrationManagementController::index
 * @see app/Http/Controllers/Admin/RegistrationManagementController.php:16
 * @route '/admin/registrations'
 */
    const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: index.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Admin\RegistrationManagementController::index
 * @see app/Http/Controllers/Admin/RegistrationManagementController.php:16
 * @route '/admin/registrations'
 */
        indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: index.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Admin\RegistrationManagementController::index
 * @see app/Http/Controllers/Admin/RegistrationManagementController.php:16
 * @route '/admin/registrations'
 */
        indexForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: index.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    index.form = indexForm
/**
* @see \App\Http\Controllers\Admin\RegistrationManagementController::exportMethod
 * @see app/Http/Controllers/Admin/RegistrationManagementController.php:92
 * @route '/admin/registrations/export'
 */
export const exportMethod = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: exportMethod.url(options),
    method: 'get',
})

exportMethod.definition = {
    methods: ["get","head"],
    url: '/admin/registrations/export',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Admin\RegistrationManagementController::exportMethod
 * @see app/Http/Controllers/Admin/RegistrationManagementController.php:92
 * @route '/admin/registrations/export'
 */
exportMethod.url = (options?: RouteQueryOptions) => {
    return exportMethod.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\RegistrationManagementController::exportMethod
 * @see app/Http/Controllers/Admin/RegistrationManagementController.php:92
 * @route '/admin/registrations/export'
 */
exportMethod.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: exportMethod.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Admin\RegistrationManagementController::exportMethod
 * @see app/Http/Controllers/Admin/RegistrationManagementController.php:92
 * @route '/admin/registrations/export'
 */
exportMethod.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: exportMethod.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Admin\RegistrationManagementController::exportMethod
 * @see app/Http/Controllers/Admin/RegistrationManagementController.php:92
 * @route '/admin/registrations/export'
 */
    const exportMethodForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: exportMethod.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Admin\RegistrationManagementController::exportMethod
 * @see app/Http/Controllers/Admin/RegistrationManagementController.php:92
 * @route '/admin/registrations/export'
 */
        exportMethodForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: exportMethod.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Admin\RegistrationManagementController::exportMethod
 * @see app/Http/Controllers/Admin/RegistrationManagementController.php:92
 * @route '/admin/registrations/export'
 */
        exportMethodForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: exportMethod.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    exportMethod.form = exportMethodForm
/**
* @see \App\Http\Controllers\Admin\RegistrationManagementController::badge
 * @see app/Http/Controllers/Admin/RegistrationManagementController.php:62
 * @route '/admin/registrations/{id}/badge'
 */
export const badge = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: badge.url(args, options),
    method: 'post',
})

badge.definition = {
    methods: ["post"],
    url: '/admin/registrations/{id}/badge',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Admin\RegistrationManagementController::badge
 * @see app/Http/Controllers/Admin/RegistrationManagementController.php:62
 * @route '/admin/registrations/{id}/badge'
 */
badge.url = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { id: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    id: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        id: args.id,
                }

    return badge.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\RegistrationManagementController::badge
 * @see app/Http/Controllers/Admin/RegistrationManagementController.php:62
 * @route '/admin/registrations/{id}/badge'
 */
badge.post = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: badge.url(args, options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\Admin\RegistrationManagementController::badge
 * @see app/Http/Controllers/Admin/RegistrationManagementController.php:62
 * @route '/admin/registrations/{id}/badge'
 */
    const badgeForm = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: badge.url(args, options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Admin\RegistrationManagementController::badge
 * @see app/Http/Controllers/Admin/RegistrationManagementController.php:62
 * @route '/admin/registrations/{id}/badge'
 */
        badgeForm.post = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: badge.url(args, options),
            method: 'post',
        })
    
    badge.form = badgeForm
/**
* @see \App\Http\Controllers\Admin\RegistrationManagementController::invoice
 * @see app/Http/Controllers/Admin/RegistrationManagementController.php:70
 * @route '/admin/registrations/{id}/invoice'
 */
export const invoice = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: invoice.url(args, options),
    method: 'post',
})

invoice.definition = {
    methods: ["post"],
    url: '/admin/registrations/{id}/invoice',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Admin\RegistrationManagementController::invoice
 * @see app/Http/Controllers/Admin/RegistrationManagementController.php:70
 * @route '/admin/registrations/{id}/invoice'
 */
invoice.url = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { id: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    id: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        id: args.id,
                }

    return invoice.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\RegistrationManagementController::invoice
 * @see app/Http/Controllers/Admin/RegistrationManagementController.php:70
 * @route '/admin/registrations/{id}/invoice'
 */
invoice.post = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: invoice.url(args, options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\Admin\RegistrationManagementController::invoice
 * @see app/Http/Controllers/Admin/RegistrationManagementController.php:70
 * @route '/admin/registrations/{id}/invoice'
 */
    const invoiceForm = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: invoice.url(args, options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Admin\RegistrationManagementController::invoice
 * @see app/Http/Controllers/Admin/RegistrationManagementController.php:70
 * @route '/admin/registrations/{id}/invoice'
 */
        invoiceForm.post = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: invoice.url(args, options),
            method: 'post',
        })
    
    invoice.form = invoiceForm
/**
* @see \App\Http\Controllers\Admin\RegistrationManagementController::cancel
 * @see app/Http/Controllers/Admin/RegistrationManagementController.php:78
 * @route '/admin/registrations/{id}/cancel'
 */
export const cancel = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: cancel.url(args, options),
    method: 'post',
})

cancel.definition = {
    methods: ["post"],
    url: '/admin/registrations/{id}/cancel',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Admin\RegistrationManagementController::cancel
 * @see app/Http/Controllers/Admin/RegistrationManagementController.php:78
 * @route '/admin/registrations/{id}/cancel'
 */
cancel.url = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { id: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    id: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        id: args.id,
                }

    return cancel.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\RegistrationManagementController::cancel
 * @see app/Http/Controllers/Admin/RegistrationManagementController.php:78
 * @route '/admin/registrations/{id}/cancel'
 */
cancel.post = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: cancel.url(args, options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\Admin\RegistrationManagementController::cancel
 * @see app/Http/Controllers/Admin/RegistrationManagementController.php:78
 * @route '/admin/registrations/{id}/cancel'
 */
    const cancelForm = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: cancel.url(args, options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Admin\RegistrationManagementController::cancel
 * @see app/Http/Controllers/Admin/RegistrationManagementController.php:78
 * @route '/admin/registrations/{id}/cancel'
 */
        cancelForm.post = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: cancel.url(args, options),
            method: 'post',
        })
    
    cancel.form = cancelForm
const registrations = {
    index: Object.assign(index, index),
export: Object.assign(exportMethod, exportMethod),
badge: Object.assign(badge, badge),
invoice: Object.assign(invoice, invoice),
cancel: Object.assign(cancel, cancel),
}

export default registrations