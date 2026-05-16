import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\Public\AbstractController::submit
 * @see app/Http/Controllers/Public/AbstractController.php:82
 * @route '/abstracts/lookup'
 */
export const submit = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: submit.url(options),
    method: 'post',
})

submit.definition = {
    methods: ["post"],
    url: '/abstracts/lookup',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Public\AbstractController::submit
 * @see app/Http/Controllers/Public/AbstractController.php:82
 * @route '/abstracts/lookup'
 */
submit.url = (options?: RouteQueryOptions) => {
    return submit.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Public\AbstractController::submit
 * @see app/Http/Controllers/Public/AbstractController.php:82
 * @route '/abstracts/lookup'
 */
submit.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: submit.url(options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\Public\AbstractController::submit
 * @see app/Http/Controllers/Public/AbstractController.php:82
 * @route '/abstracts/lookup'
 */
    const submitForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: submit.url(options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Public\AbstractController::submit
 * @see app/Http/Controllers/Public/AbstractController.php:82
 * @route '/abstracts/lookup'
 */
        submitForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: submit.url(options),
            method: 'post',
        })
    
    submit.form = submitForm
const lookup = {
    submit: Object.assign(submit, submit),
}

export default lookup