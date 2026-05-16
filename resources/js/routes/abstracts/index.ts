import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../wayfinder'
import lookupAe55f1 from './lookup'
/**
* @see \App\Http\Controllers\Public\AbstractController::submit
 * @see app/Http/Controllers/Public/AbstractController.php:23
 * @route '/abstracts/submit'
 */
export const submit = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: submit.url(options),
    method: 'get',
})

submit.definition = {
    methods: ["get","head"],
    url: '/abstracts/submit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Public\AbstractController::submit
 * @see app/Http/Controllers/Public/AbstractController.php:23
 * @route '/abstracts/submit'
 */
submit.url = (options?: RouteQueryOptions) => {
    return submit.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Public\AbstractController::submit
 * @see app/Http/Controllers/Public/AbstractController.php:23
 * @route '/abstracts/submit'
 */
submit.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: submit.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Public\AbstractController::submit
 * @see app/Http/Controllers/Public/AbstractController.php:23
 * @route '/abstracts/submit'
 */
submit.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: submit.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Public\AbstractController::submit
 * @see app/Http/Controllers/Public/AbstractController.php:23
 * @route '/abstracts/submit'
 */
    const submitForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: submit.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Public\AbstractController::submit
 * @see app/Http/Controllers/Public/AbstractController.php:23
 * @route '/abstracts/submit'
 */
        submitForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: submit.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Public\AbstractController::submit
 * @see app/Http/Controllers/Public/AbstractController.php:23
 * @route '/abstracts/submit'
 */
        submitForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: submit.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    submit.form = submitForm
/**
* @see \App\Http\Controllers\Public\AbstractController::store
 * @see app/Http/Controllers/Public/AbstractController.php:46
 * @route '/abstracts/submit'
 */
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/abstracts/submit',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Public\AbstractController::store
 * @see app/Http/Controllers/Public/AbstractController.php:46
 * @route '/abstracts/submit'
 */
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Public\AbstractController::store
 * @see app/Http/Controllers/Public/AbstractController.php:46
 * @route '/abstracts/submit'
 */
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\Public\AbstractController::store
 * @see app/Http/Controllers/Public/AbstractController.php:46
 * @route '/abstracts/submit'
 */
    const storeForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: store.url(options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Public\AbstractController::store
 * @see app/Http/Controllers/Public/AbstractController.php:46
 * @route '/abstracts/submit'
 */
        storeForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: store.url(options),
            method: 'post',
        })
    
    store.form = storeForm
/**
* @see \App\Http\Controllers\Public\AbstractController::submitted
 * @see app/Http/Controllers/Public/AbstractController.php:56
 * @route '/abstracts/{reference}/submitted'
 */
export const submitted = (args: { reference: string | number } | [reference: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: submitted.url(args, options),
    method: 'get',
})

submitted.definition = {
    methods: ["get","head"],
    url: '/abstracts/{reference}/submitted',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Public\AbstractController::submitted
 * @see app/Http/Controllers/Public/AbstractController.php:56
 * @route '/abstracts/{reference}/submitted'
 */
submitted.url = (args: { reference: string | number } | [reference: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return submitted.definition.url
            .replace('{reference}', parsedArgs.reference.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Public\AbstractController::submitted
 * @see app/Http/Controllers/Public/AbstractController.php:56
 * @route '/abstracts/{reference}/submitted'
 */
submitted.get = (args: { reference: string | number } | [reference: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: submitted.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Public\AbstractController::submitted
 * @see app/Http/Controllers/Public/AbstractController.php:56
 * @route '/abstracts/{reference}/submitted'
 */
submitted.head = (args: { reference: string | number } | [reference: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: submitted.url(args, options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Public\AbstractController::submitted
 * @see app/Http/Controllers/Public/AbstractController.php:56
 * @route '/abstracts/{reference}/submitted'
 */
    const submittedForm = (args: { reference: string | number } | [reference: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: submitted.url(args, options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Public\AbstractController::submitted
 * @see app/Http/Controllers/Public/AbstractController.php:56
 * @route '/abstracts/{reference}/submitted'
 */
        submittedForm.get = (args: { reference: string | number } | [reference: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: submitted.url(args, options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Public\AbstractController::submitted
 * @see app/Http/Controllers/Public/AbstractController.php:56
 * @route '/abstracts/{reference}/submitted'
 */
        submittedForm.head = (args: { reference: string | number } | [reference: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: submitted.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    submitted.form = submittedForm
/**
* @see \App\Http\Controllers\Public\AbstractController::lookup
 * @see app/Http/Controllers/Public/AbstractController.php:77
 * @route '/abstracts/lookup'
 */
export const lookup = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: lookup.url(options),
    method: 'get',
})

lookup.definition = {
    methods: ["get","head"],
    url: '/abstracts/lookup',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Public\AbstractController::lookup
 * @see app/Http/Controllers/Public/AbstractController.php:77
 * @route '/abstracts/lookup'
 */
lookup.url = (options?: RouteQueryOptions) => {
    return lookup.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Public\AbstractController::lookup
 * @see app/Http/Controllers/Public/AbstractController.php:77
 * @route '/abstracts/lookup'
 */
lookup.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: lookup.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Public\AbstractController::lookup
 * @see app/Http/Controllers/Public/AbstractController.php:77
 * @route '/abstracts/lookup'
 */
lookup.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: lookup.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Public\AbstractController::lookup
 * @see app/Http/Controllers/Public/AbstractController.php:77
 * @route '/abstracts/lookup'
 */
    const lookupForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: lookup.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Public\AbstractController::lookup
 * @see app/Http/Controllers/Public/AbstractController.php:77
 * @route '/abstracts/lookup'
 */
        lookupForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: lookup.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Public\AbstractController::lookup
 * @see app/Http/Controllers/Public/AbstractController.php:77
 * @route '/abstracts/lookup'
 */
        lookupForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: lookup.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    lookup.form = lookupForm
const abstracts = {
    submit: Object.assign(submit, submit),
store: Object.assign(store, store),
submitted: Object.assign(submitted, submitted),
lookup: Object.assign(lookup, lookupAe55f1),
}

export default abstracts