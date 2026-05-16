import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Public\RegistrationController::index
 * @see app/Http/Controllers/Public/RegistrationController.php:29
 * @route '/inscription'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/inscription',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Public\RegistrationController::index
 * @see app/Http/Controllers/Public/RegistrationController.php:29
 * @route '/inscription'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Public\RegistrationController::index
 * @see app/Http/Controllers/Public/RegistrationController.php:29
 * @route '/inscription'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Public\RegistrationController::index
 * @see app/Http/Controllers/Public/RegistrationController.php:29
 * @route '/inscription'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Public\RegistrationController::index
 * @see app/Http/Controllers/Public/RegistrationController.php:29
 * @route '/inscription'
 */
    const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: index.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Public\RegistrationController::index
 * @see app/Http/Controllers/Public/RegistrationController.php:29
 * @route '/inscription'
 */
        indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: index.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Public\RegistrationController::index
 * @see app/Http/Controllers/Public/RegistrationController.php:29
 * @route '/inscription'
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
* @see \App\Http\Controllers\Public\RegistrationController::checkPromo
 * @see app/Http/Controllers/Public/RegistrationController.php:67
 * @route '/inscription/promo-check'
 */
export const checkPromo = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: checkPromo.url(options),
    method: 'post',
})

checkPromo.definition = {
    methods: ["post"],
    url: '/inscription/promo-check',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Public\RegistrationController::checkPromo
 * @see app/Http/Controllers/Public/RegistrationController.php:67
 * @route '/inscription/promo-check'
 */
checkPromo.url = (options?: RouteQueryOptions) => {
    return checkPromo.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Public\RegistrationController::checkPromo
 * @see app/Http/Controllers/Public/RegistrationController.php:67
 * @route '/inscription/promo-check'
 */
checkPromo.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: checkPromo.url(options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\Public\RegistrationController::checkPromo
 * @see app/Http/Controllers/Public/RegistrationController.php:67
 * @route '/inscription/promo-check'
 */
    const checkPromoForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: checkPromo.url(options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Public\RegistrationController::checkPromo
 * @see app/Http/Controllers/Public/RegistrationController.php:67
 * @route '/inscription/promo-check'
 */
        checkPromoForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: checkPromo.url(options),
            method: 'post',
        })
    
    checkPromo.form = checkPromoForm
/**
* @see \App\Http\Controllers\Public\RegistrationController::store
 * @see app/Http/Controllers/Public/RegistrationController.php:80
 * @route '/inscription'
 */
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/inscription',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Public\RegistrationController::store
 * @see app/Http/Controllers/Public/RegistrationController.php:80
 * @route '/inscription'
 */
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Public\RegistrationController::store
 * @see app/Http/Controllers/Public/RegistrationController.php:80
 * @route '/inscription'
 */
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\Public\RegistrationController::store
 * @see app/Http/Controllers/Public/RegistrationController.php:80
 * @route '/inscription'
 */
    const storeForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: store.url(options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Public\RegistrationController::store
 * @see app/Http/Controllers/Public/RegistrationController.php:80
 * @route '/inscription'
 */
        storeForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: store.url(options),
            method: 'post',
        })
    
    store.form = storeForm
/**
* @see \App\Http\Controllers\Public\RegistrationController::confirmation
 * @see app/Http/Controllers/Public/RegistrationController.php:153
 * @route '/inscription/{reference}/confirmation'
 */
export const confirmation = (args: { reference: string | number } | [reference: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: confirmation.url(args, options),
    method: 'get',
})

confirmation.definition = {
    methods: ["get","head"],
    url: '/inscription/{reference}/confirmation',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Public\RegistrationController::confirmation
 * @see app/Http/Controllers/Public/RegistrationController.php:153
 * @route '/inscription/{reference}/confirmation'
 */
confirmation.url = (args: { reference: string | number } | [reference: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { reference: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    reference: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        reference: args.reference,
                }

    return confirmation.definition.url
            .replace('{reference}', parsedArgs.reference.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Public\RegistrationController::confirmation
 * @see app/Http/Controllers/Public/RegistrationController.php:153
 * @route '/inscription/{reference}/confirmation'
 */
confirmation.get = (args: { reference: string | number } | [reference: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: confirmation.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Public\RegistrationController::confirmation
 * @see app/Http/Controllers/Public/RegistrationController.php:153
 * @route '/inscription/{reference}/confirmation'
 */
confirmation.head = (args: { reference: string | number } | [reference: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: confirmation.url(args, options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Public\RegistrationController::confirmation
 * @see app/Http/Controllers/Public/RegistrationController.php:153
 * @route '/inscription/{reference}/confirmation'
 */
    const confirmationForm = (args: { reference: string | number } | [reference: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: confirmation.url(args, options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Public\RegistrationController::confirmation
 * @see app/Http/Controllers/Public/RegistrationController.php:153
 * @route '/inscription/{reference}/confirmation'
 */
        confirmationForm.get = (args: { reference: string | number } | [reference: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: confirmation.url(args, options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Public\RegistrationController::confirmation
 * @see app/Http/Controllers/Public/RegistrationController.php:153
 * @route '/inscription/{reference}/confirmation'
 */
        confirmationForm.head = (args: { reference: string | number } | [reference: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: confirmation.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    confirmation.form = confirmationForm
const RegistrationController = { index, checkPromo, store, confirmation }

export default RegistrationController