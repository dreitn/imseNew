FROM alpine
WORKDIR /root/test-data-generator
COPY TestDataGenerator.java /root/test-data-generator
COPY Firmennamen.txt /root/test-data-generator
COPY mysql-connector-java-8.0.18.jar /root/test-data-generator
COPY Namen.txt /root/test-data-generator

RUN apk add openjdk8
ENV JAVA_HOME /usr/lib/jvm/java-1.8-openjdk
ENV PATH $PATH:$JAVA_HOME/bin


RUN javac -classpath mysql-connector-java-8.0.18.jar:. TestDataGenerator.java
ENTRYPOINT java -classpath mysql-connector-java-8.0.18.jar:. TestDataGenerator
