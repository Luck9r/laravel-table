# Laravel Table
## Setup
Project requires a running Mysql database (with default settings). In my case, it was set up using sail.
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
