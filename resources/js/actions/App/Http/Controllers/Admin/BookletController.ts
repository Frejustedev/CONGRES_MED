import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Admin\BookletController::__invoke
 * @see app/Http/Controllers/Admin/BookletController.php:12
 * @route '/admin/abstracts/booklet'
 */
const BookletController = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: BookletController.url(options),
    method: 'get',
})

BookletController.definition = {
    methods: ["get","head"],
    url: '/admin/abstracts/booklet',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Admin\BookletController::__invoke
 * @see app/Http/Controllers/Admin/BookletController.php:12
 * @route '/admin/abstracts/booklet'
 */
BookletController.url = (options?: RouteQueryOptions) => {
    return BookletController.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\BookletController::__invoke
 * @see app/Http/Controllers/Admin/BookletController.php:12
 * @route '/admin/abstracts/booklet'
 */
BookletController.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: BookletController.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Admin\BookletController::__invoke
 * @see app/Http/Controllers/Admin/BookletController.php:12
 * @route '/admin/abstracts/booklet'
 */
BookletController.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: BookletController.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Admin\BookletController::__invoke
 * @see app/Http/Controllers/Admin/BookletController.php:12
 * @route '/admin/abstracts/booklet'
 */
    const BookletControllerForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: BookletController.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Admin\BookletController::__invoke
 * @see app/Http/Controllers/Admin/BookletController.php:12
 * @route '/admin/abstracts/booklet'
 */
        BookletControllerForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: BookletController.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Admin\BookletController::__invoke
 * @see app/Http/Controllers/Admin/BookletController.php:12
 * @route '/admin/abstracts/booklet'
 */
        BookletControllerForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: BookletController.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    BookletController.form = BookletControllerForm
export default BookletController