import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Public\LegalController::terms
 * @see app/Http/Controllers/Public/LegalController.php:13
 * @route '/cgv'
 */
export const terms = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: terms.url(options),
    method: 'get',
})

terms.definition = {
    methods: ["get","head"],
    url: '/cgv',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Public\LegalController::terms
 * @see app/Http/Controllers/Public/LegalController.php:13
 * @route '/cgv'
 */
terms.url = (options?: RouteQueryOptions) => {
    return terms.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Public\LegalController::terms
 * @see app/Http/Controllers/Public/LegalController.php:13
 * @route '/cgv'
 */
terms.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: terms.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Public\LegalController::terms
 * @see app/Http/Controllers/Public/LegalController.php:13
 * @route '/cgv'
 */
terms.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: terms.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Public\LegalController::terms
 * @see app/Http/Controllers/Public/LegalController.php:13
 * @route '/cgv'
 */
    const termsForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: terms.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Public\LegalController::terms
 * @see app/Http/Controllers/Public/LegalController.php:13
 * @route '/cgv'
 */
        termsForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: terms.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Public\LegalController::terms
 * @see app/Http/Controllers/Public/LegalController.php:13
 * @route '/cgv'
 */
        termsForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: terms.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    terms.form = termsForm
/**
* @see \App\Http\Controllers\Public\LegalController::privacy
 * @see app/Http/Controllers/Public/LegalController.php:18
 * @route '/confidentialite'
 */
export const privacy = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: privacy.url(options),
    method: 'get',
})

privacy.definition = {
    methods: ["get","head"],
    url: '/confidentialite',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Public\LegalController::privacy
 * @see app/Http/Controllers/Public/LegalController.php:18
 * @route '/confidentialite'
 */
privacy.url = (options?: RouteQueryOptions) => {
    return privacy.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Public\LegalController::privacy
 * @see app/Http/Controllers/Public/LegalController.php:18
 * @route '/confidentialite'
 */
privacy.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: privacy.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Public\LegalController::privacy
 * @see app/Http/Controllers/Public/LegalController.php:18
 * @route '/confidentialite'
 */
privacy.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: privacy.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Public\LegalController::privacy
 * @see app/Http/Controllers/Public/LegalController.php:18
 * @route '/confidentialite'
 */
    const privacyForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: privacy.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Public\LegalController::privacy
 * @see app/Http/Controllers/Public/LegalController.php:18
 * @route '/confidentialite'
 */
        privacyForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: privacy.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Public\LegalController::privacy
 * @see app/Http/Controllers/Public/LegalController.php:18
 * @route '/confidentialite'
 */
        privacyForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: privacy.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    privacy.form = privacyForm
/**
* @see \App\Http\Controllers\Public\LegalController::mentions
 * @see app/Http/Controllers/Public/LegalController.php:23
 * @route '/mentions-legales'
 */
export const mentions = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: mentions.url(options),
    method: 'get',
})

mentions.definition = {
    methods: ["get","head"],
    url: '/mentions-legales',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Public\LegalController::mentions
 * @see app/Http/Controllers/Public/LegalController.php:23
 * @route '/mentions-legales'
 */
mentions.url = (options?: RouteQueryOptions) => {
    return mentions.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Public\LegalController::mentions
 * @see app/Http/Controllers/Public/LegalController.php:23
 * @route '/mentions-legales'
 */
mentions.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: mentions.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Public\LegalController::mentions
 * @see app/Http/Controllers/Public/LegalController.php:23
 * @route '/mentions-legales'
 */
mentions.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: mentions.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Public\LegalController::mentions
 * @see app/Http/Controllers/Public/LegalController.php:23
 * @route '/mentions-legales'
 */
    const mentionsForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: mentions.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Public\LegalController::mentions
 * @see app/Http/Controllers/Public/LegalController.php:23
 * @route '/mentions-legales'
 */
        mentionsForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: mentions.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Public\LegalController::mentions
 * @see app/Http/Controllers/Public/LegalController.php:23
 * @route '/mentions-legales'
 */
        mentionsForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: mentions.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    mentions.form = mentionsForm
const LegalController = { terms, privacy, mentions }

export default LegalController