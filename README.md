
# News Board App

This project have made for test case


## Technology Stack

**Client:** Vuejs, TailwindCSS

**Server:** Laravel

## How to install

Clone the project

```bash
  git clone https://github.com/eroltukenmez/news-board-app.git
```

Go to the project directory

```bash
  cd news-board-app
```

Create your .env file

```bash
  cp .env.example .env
```

Enter api information for news into .env file

```
NEWS_API_KEY=
NEWS_API_URL=https://newsapi.org/v2

GUARDIAN_API_KEY=
GUARDIAN_API_URL=https://content.guardianapis.com/

NEW_YORK_TIME_API_KEY=
NEW_YORK_TIME_API_URL=https://api.nytimes.com/svc/news/v3/
```

Run the seerver

```bash
  docker compose up -d
```

### Docker Port Configuration

By default, Docker will start Nginx on port `8001`. You can customize this by setting the `APP_PORT` variable in your `.env` file.

For example, you can add the following line to your `.env` file: 
```
APP_PORT=8080
```
This will configure Nginx to listen on port `8080` instead of the default `8001`.