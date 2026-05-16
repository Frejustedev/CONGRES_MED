import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../wayfinder'
/**
* @see \App\Http\Controllers\Public\SymposiumController::index
 * @see app/Http/Controllers/Public/SymposiumController.php:17
 * @route '/symposiums'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/symposiums',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Public\SymposiumController::index
 * @see app/Http/Controllers/Public/SymposiumController.php:17
 * @route '/symposiums'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Public\SymposiumController::index
 * @see app/Http/Controllers/Public/SymposiumController.php:17
 * @route '/symposiums'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Public\SymposiumController::index
 * @see app/Http/Controllers/Public/SymposiumController.php:17
 * @route '/symposiums'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Public\SymposiumController::index
 * @see app/Http/Controllers/Public/SymposiumController.php:17
 * @route '/symposiums'
 */
    const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: index.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Public\SymposiumController::index
 * @see app/Http/Controllers/Public/SymposiumController.php:17
 * @route '/symposiums'
 */
        indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: index.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Public\SymposiumController::index
 * @see app/Http/Controllers/Public/SymposiumController.php:17
 * @route '/symposiums'
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
* @see \App\Http\Controllers\Public\SymposiumController::show
 * @see app/Http/Controllers/Public/SymposiumController.php:34
 * @route '/symposiums/{slug}'
 */
export const show = (args: { slug: string | number } | [slug: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/symposiums/{slug}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Public\SymposiumController::show
 * @see app/Http/Controllers/Public/SymposiumController.php:34
 * @route '/symposiums/{slug}'
 */
show.url = (args: { slug: string | number } | [slug: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { slug: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    slug: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        slug: args.slug,
                }

    return show.definition.url
            .replace('{slug}', parsedArgs.slug.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Public\SymposiumController::show
 * @see app/Http/Controllers/Public/SymposiumController.php:34
 * @route '/symposiums/{slug}'
 */
show.get = (args: { slug: string | number } | [slug: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Public\SymposiumController::show
 * @see app/Http/Controllers/Public/SymposiumController.php:34
 * @route '/symposiums/{slug}'
 */
show.head = (args: { slug: string | number } | [slug: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Public\SymposiumController::show
 * @see app/Http/Controllers/Public/SymposiumController.php:34
 * @route '/symposiums/{slug}'
 */
    const showForm = (args: { slug: string | number } | [slug: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: show.url(args, options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Public\SymposiumController::show
 * @see app/Http/Controllers/Public/SymposiumController.php:34
 * @route '/symposiums/{slug}'
 */
        showForm.get = (args: { slug: string | number } | [slug: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: show.url(args, options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Public\SymposiumController::show
 * @see app/Http/Controllers/Public/SymposiumController.php:34
 * @route '/symposiums/{slug}'
 */
        showForm.head = (args: { slug: string | number } | [slug: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: show.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    show.form = showForm
/**
* @see \App\Http\Controllers\Public\SymposiumController::register
 * @see app/Http/Controllers/Public/SymposiumController.php:46
 * @route '/symposiums/{slug}/register'
 */
export const register = (args: { slug: string | number } | [slug: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: register.url(args, options),
    method: 'post',
})

register.definition = {
    methods: ["post"],
    url: '/symposiums/{slug}/register',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Public\SymposiumController::register
 * @see app/Http/Controllers/Public/SymposiumController.php:46
 * @route '/symposiums/{slug}/register'
 */
register.url = (args: { slug: string | number } | [slug: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { slug: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    slug: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        slug: args.slug,
                }

    return register.definition.url
            .replace('{slug}', parsedArgs.slug.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Public\SymposiumController::register
 * @see app/Http/Controllers/Public/SymposiumController.php:46
 * @route '/symposiums/{slug}/register'
 */
register.post = (args: { slug: string | number } | [slug: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: register.url(args, options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\Public\SymposiumController::register
 * @see app/Http/Controllers/Public/SymposiumController.php:46
 * @route '/symposiums/{slug}/register'
 */
    const registerForm = (args: { slug: string | number } | [slug: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: register.url(args, options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Public\SymposiumController::register
 * @see app/Http/Controllers/Public/SymposiumController.php:46
 * @route '/symposiums/{slug}/register'
 */
        registerForm.post = (args: { slug: string | number } | [slug: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: register.url(args, options),
            method: 'post',
        })
    
    register.form = registerForm
const symposiums = {
    index: Object.assign(index, index),
show: Object.assign(show, show),
register: Object.assign(register, register),
}

export default symposiums