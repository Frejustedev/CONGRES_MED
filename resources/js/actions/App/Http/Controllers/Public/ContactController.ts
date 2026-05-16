import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Public\ContactController::index
 * @see app/Http/Controllers/Public/ContactController.php:14
 * @route '/contact'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/contact',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Public\ContactController::index
 * @see app/Http/Controllers/Public/ContactController.php:14
 * @route '/contact'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Public\ContactController::index
 * @see app/Http/Controllers/Public/ContactController.php:14
 * @route '/contact'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Public\ContactController::index
 * @see app/Http/Controllers/Public/ContactController.php:14
 * @route '/contact'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Public\ContactController::index
 * @see app/Http/Controllers/Public/ContactController.php:14
 * @route '/contact'
 */
    const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: index.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Public\ContactController::index
 * @see app/Http/Controllers/Public/ContactController.php:14
 * @route '/contact'
 */
        indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: index.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Public\ContactController::index
 * @see app/Http/Controllers/Public/ContactController.php:14
 * @route '/contact'
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
* @see \App\Http\Controllers\Public\ContactController::send
 * @see app/Http/Controllers/Public/ContactController.php:27
 * @route '/contact'
 */
export const send = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: send.url(options),
    method: 'post',
})

send.definition = {
    methods: ["post"],
    url: '/contact',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Public\ContactController::send
 * @see app/Http/Controllers/Public/ContactController.php:27
 * @route '/contact'
 */
send.url = (options?: RouteQueryOptions) => {
    return send.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Public\ContactController::send
 * @see app/Http/Controllers/Public/ContactController.php:27
 * @route '/contact'
 */
send.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: send.url(options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\Public\ContactController::send
 * @see app/Http/Controllers/Public/ContactController.php:27
 * @route '/contact'
 */
    const sendForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: send.url(options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Public\ContactController::send
 * @see app/Http/Controllers/Public/ContactController.php:27
 * @route '/contact'
 */
        sendForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: send.url(options),
            method: 'post',
        })
    
    send.form = sendForm
const ContactController = { index, send }

export default ContactController