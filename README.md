
# News Board App

This project have made for test case


## Technology Stack

**Client:** Vuejs, TailwindCSS

**Server:** Laravel

## How to install

Clone the project

```bash
  git clone https://link-to-project
```

Go to the project directory

```bash
  cd my-project
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
