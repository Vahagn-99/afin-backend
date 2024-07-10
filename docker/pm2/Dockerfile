# Use a Node.js base image
FROM node:latest

# Set a working directory
WORKDIR /var/www/html

COPY . .

# Install pm2 globally
RUN npm install pm2 -g

# Define the command to run when the container starts
CMD ["pm2-runtime", "start", "ecosystem.config.js"]
