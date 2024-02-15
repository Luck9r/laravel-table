# Laravel Table
Uses Laravel for the backend and the Materialize CSS framework with own javascript for the frontend.

The frontend makes requests to the backend, which has three endpoints:
```bash
/api/ads            # returns all ads ordered by impressions 
/api/ads/find/{id}  # returns a single ad with a given ad_id
/api/ads/paginate   # returns a list of ads, filtered and paginated
```
(For demonstration purposes, only the pagination endpoint is utilized in the App)

The Database connection is implemented with Eloquent ORM for increased convenience and safety.
## Setup
Project requires a running MySQL database (with default settings). In my case, it was set up using sail.
### Node
Node dependencies need to be installed:
```bash
npm install
```
Or with sail:
```bash
sail npm install
```
### Mix
Assets need to be compiled and bundled with Laravel Mix:
```bash
npx mix
```
Or with sail:
```bash
sail npx mix
```
### Database
The table is created and configured by running the included migrations:
```bash
php artisan migrate
```
Or if you're using sail:
```bash
sail artisan migrate
```
### Data
Data for the table view is fetched with an artisan command:
```bash
php artisan app:fetch-ads
```
Or if you're using sail:
```bash
sail artisan app:fetch-ads
```
