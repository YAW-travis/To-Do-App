# use the official PHP image from Docker Hub
FROM php:8.1-cli

# Create the /app directory
RUN mkdir /app

# Set the working directory inside the container
WORKDIR /app

# Copy your application files into the container
COPY . .

# Expose the Render-provided port
EXPOSE 8080

# Default to using Render's port (or fallback to 8080 for local testing)
ENV PORT=8080

# Start the built-in PHP server on the specified port
CMD ["sh", "-c", "php -S 0.0.0.0:$PORT -t /app"]