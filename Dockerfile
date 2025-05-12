# Use an official PHP runtime as a parent image
FROM php:7.4-apache

# Set the working directory in the container to /var/www/html
WORKDIR /var/www/html

# Copy the current directory contents into the container at /var/www/html
COPY . /var/www/html

# Install dependencies
RUN apt-get update && \
    apt-get upgrade -y && \
    apt-get install -y git

# Expose port 80
EXPOSE 80

# Command to run the Apache server
CMD ["apache2-foreground"]
