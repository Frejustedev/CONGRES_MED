import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\Reviewer\ReviewController::show
 * @see app/Http/Controllers/Reviewer/ReviewController.php:46
 * @route '/reviewer/reviews/{review}'
 */
export const show = (args: { review: string | number } | [review: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/reviewer/reviews/{review}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Reviewer\ReviewController::show
 * @see app/Http/Controllers/Reviewer/ReviewController.php:46
 * @route '/reviewer/reviews/{review}'
 */
show.url = (args: { review: string | number } | [review: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { review: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    review: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        review: args.review,
                }

    return show.definition.url
            .replace('{review}', parsedArgs.review.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Reviewer\ReviewController::show
 * @see app/Http/Controllers/Reviewer/ReviewController.php:46
 * @route '/reviewer/reviews/{review}'
 */
show.get = (args: { review: string | number } | [review: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Reviewer\ReviewController::show
 * @see app/Http/Controllers/Reviewer/ReviewController.php:46
 * @route '/reviewer/reviews/{review}'
 */
show.head = (args: { review: string | number } | [review: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Reviewer\ReviewController::show
 * @see app/Http/Controllers/Reviewer/ReviewController.php:46
 * @route '/reviewer/reviews/{review}'
 */
    const showForm = (args: { review: string | number } | [review: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: show.url(args, options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Reviewer\ReviewController::show
 * @see app/Http/Controllers/Reviewer/ReviewController.php:46
 * @route '/reviewer/reviews/{review}'
 */
        showForm.get = (args: { review: string | number } | [review: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: show.url(args, options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Reviewer\ReviewController::show
 * @see app/Http/Controllers/Reviewer/ReviewController.php:46
 * @route '/reviewer/reviews/{review}'
 */
        showForm.head = (args: { review: string | number } | [review: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
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
* @see \App\Http\Controllers\Reviewer\ReviewController::submit
 * @see app/Http/Controllers/Reviewer/ReviewController.php:99
 * @route '/reviewer/reviews/{review}'
 */
export const submit = (args: { review: string | number } | [review: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: submit.url(args, options),
    method: 'post',
})

submit.definition = {
    methods: ["post"],
    url: '/reviewer/reviews/{review}',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Reviewer\ReviewController::submit
 * @see app/Http/Controllers/Reviewer/ReviewController.php:99
 * @route '/reviewer/reviews/{review}'
 */
submit.url = (args: { review: string | number } | [review: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { review: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    review: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        review: args.review,
                }

    return submit.definition.url
            .replace('{review}', parsedArgs.review.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Reviewer\ReviewController::submit
 * @see app/Http/Controllers/Reviewer/ReviewController.php:99
 * @route '/reviewer/reviews/{review}'
 */
submit.post = (args: { review: string | number } | [review: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: submit.url(args, options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\Reviewer\ReviewController::submit
 * @see app/Http/Controllers/Reviewer/ReviewController.php:99
 * @route '/reviewer/reviews/{review}'
 */
    const submitForm = (args: { review: string | number } | [review: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: submit.url(args, options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Reviewer\ReviewController::submit
 * @see app/Http/Controllers/Reviewer/ReviewController.php:99
 * @route '/reviewer/reviews/{review}'
 */
        submitForm.post = (args: { review: string | number } | [review: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: submit.url(args, options),
            method: 'post',
        })
    
    submit.form = submitForm
const review = {
    show: Object.assign(show, show),
submit: Object.assign(submit, submit),
}

export default review