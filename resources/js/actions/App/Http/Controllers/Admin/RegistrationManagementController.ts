import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../../wayfinder'
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
* @see \App\Http\Controllers\Admin\RegistrationManagementController::exportCsv
 * @see app/Http/Controllers/Admin/RegistrationManagementController.php:92
 * @route '/admin/registrations/export'
 */
export const exportCsv = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: exportCsv.url(options),
    method: 'get',
})

exportCsv.definition = {
    methods: ["get","head"],
    url: '/admin/registrations/export',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Admin\RegistrationManagementController::exportCsv
 * @see app/Http/Controllers/Admin/RegistrationManagementController.php:92
 * @route '/admin/registrations/export'
 */
exportCsv.url = (options?: RouteQueryOptions) => {
    return exportCsv.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\RegistrationManagementController::exportCsv
 * @see app/Http/Controllers/Admin/RegistrationManagementController.php:92
 * @route '/admin/registrations/export'
 */
exportCsv.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: exportCsv.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Admin\RegistrationManagementController::exportCsv
 * @see app/Http/Controllers/Admin/RegistrationManagementController.php:92
 * @route '/admin/registrations/export'
 */
exportCsv.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: exportCsv.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Admin\RegistrationManagementController::exportCsv
 * @see app/Http/Controllers/Admin/RegistrationManagementController.php:92
 * @route '/admin/registrations/export'
 */
    const exportCsvForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: exportCsv.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Admin\RegistrationManagementController::exportCsv
 * @see app/Http/Controllers/Admin/RegistrationManagementController.php:92
 * @route '/admin/registrations/export'
 */
        exportCsvForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: exportCsv.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Admin\RegistrationManagementController::exportCsv
 * @see app/Http/Controllers/Admin/RegistrationManagementController.php:92
 * @route '/admin/registrations/export'
 */
        exportCsvForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: exportCsv.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    exportCsv.form = exportCsvForm
/**
* @see \App\Http\Controllers\Admin\RegistrationManagementController::regenerateBadge
 * @see app/Http/Controllers/Admin/RegistrationManagementController.php:62
 * @route '/admin/registrations/{id}/badge'
 */
export const regenerateBadge = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: regenerateBadge.url(args, options),
    method: 'post',
})

regenerateBadge.definition = {
    methods: ["post"],
    url: '/admin/registrations/{id}/badge',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Admin\RegistrationManagementController::regenerateBadge
 * @see app/Http/Controllers/Admin/RegistrationManagementController.php:62
 * @route '/admin/registrations/{id}/badge'
 */
regenerateBadge.url = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return regenerateBadge.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\RegistrationManagementController::regenerateBadge
 * @see app/Http/Controllers/Admin/RegistrationManagementController.php:62
 * @route '/admin/registrations/{id}/badge'
 */
regenerateBadge.post = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: regenerateBadge.url(args, options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\Admin\RegistrationManagementController::regenerateBadge
 * @see app/Http/Controllers/Admin/RegistrationManagementController.php:62
 * @route '/admin/registrations/{id}/badge'
 */
    const regenerateBadgeForm = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: regenerateBadge.url(args, options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Admin\RegistrationManagementController::regenerateBadge
 * @see app/Http/Controllers/Admin/RegistrationManagementController.php:62
 * @route '/admin/registrations/{id}/badge'
 */
        regenerateBadgeForm.post = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: regenerateBadge.url(args, options),
            method: 'post',
        })
    
    regenerateBadge.form = regenerateBadgeForm
/**
* @see \App\Http\Controllers\Admin\RegistrationManagementController::regenerateInvoice
 * @see app/Http/Controllers/Admin/RegistrationManagementController.php:70
 * @route '/admin/registrations/{id}/invoice'
 */
export const regenerateInvoice = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: regenerateInvoice.url(args, options),
    method: 'post',
})

regenerateInvoice.definition = {
    methods: ["post"],
    url: '/admin/registrations/{id}/invoice',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Admin\RegistrationManagementController::regenerateInvoice
 * @see app/Http/Controllers/Admin/RegistrationManagementController.php:70
 * @route '/admin/registrations/{id}/invoice'
 */
regenerateInvoice.url = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return regenerateInvoice.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\RegistrationManagementController::regenerateInvoice
 * @see app/Http/Controllers/Admin/RegistrationManagementController.php:70
 * @route '/admin/registrations/{id}/invoice'
 */
regenerateInvoice.post = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: regenerateInvoice.url(args, options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\Admin\RegistrationManagementController::regenerateInvoice
 * @see app/Http/Controllers/Admin/RegistrationManagementController.php:70
 * @route '/admin/registrations/{id}/invoice'
 */
    const regenerateInvoiceForm = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: regenerateInvoice.url(args, options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Admin\RegistrationManagementController::regenerateInvoice
 * @see app/Http/Controllers/Admin/RegistrationManagementController.php:70
 * @route '/admin/registrations/{id}/invoice'
 */
        regenerateInvoiceForm.post = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: regenerateInvoice.url(args, options),
            method: 'post',
        })
    
    regenerateInvoice.form = regenerateInvoiceForm
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
const RegistrationManagementController = { index, exportCsv, regenerateBadge, regenerateInvoice, cancel }

export default RegistrationManagementController